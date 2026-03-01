#!/usr/bin/env bash
set -euo pipefail

# Deploys the local project folder to a remote server.
# Supports:
#   - SSH (rsync)
#   - FTP / explicit FTPS (lftp mirror)
#
# Configure via environment variables or a local .deploy.env file.
#
# Required:
#   DEPLOY_HOST        e.g. ftp.example.com or 123.123.123.123
#   DEPLOY_USER        e.g. myuser
#   DEPLOY_REMOTE_PATH e.g. /home/myuser/public_html
#
# Optional:
#   DEPLOY_METHOD      ssh|ftp (default: ssh)
#   DEPLOY_PORT        ssh default: 22, ftp default: 21
#   DEPLOY_KEY         default: $HOME/.ssh/id_ed25519
#   DEPLOY_PASS        for ftp mode (if empty, script prompts)
#   DEPLOY_SOURCE      default: . (current project folder)
#   DEPLOY_TARGET_DIR  default: visitfy (remote subfolder under DEPLOY_REMOTE_PATH)
#   DEPLOY_EXCLUDES    comma-separated extra exclude globs (e.g. "data/foo.json,cache/**")
#   DRY_RUN            default: 0 (set 1 for preview)
#   DEPLOY_INSECURE    default: 0; set 1 to skip TLS cert verify in ftp mode
#
# Usage:
#   ./deploy.sh
#   DRY_RUN=1 ./deploy.sh
#   ./deploy.sh --delete

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

if [[ -f "${ROOT_DIR}/.deploy.env" ]]; then
  # shellcheck disable=SC1091
  source "${ROOT_DIR}/.deploy.env"
fi

DEPLOY_SOURCE="${DEPLOY_SOURCE:-.}"
DEPLOY_TARGET_DIR="${DEPLOY_TARGET_DIR:-visitfy}"
DEPLOY_METHOD="${DEPLOY_METHOD:-ssh}"
DEPLOY_KEY="${DEPLOY_KEY:-$HOME/.ssh/id_ed25519}"
DRY_RUN="${DRY_RUN:-0}"
DEPLOY_INSECURE="${DEPLOY_INSECURE:-0}"
DEPLOY_EXCLUDES="${DEPLOY_EXCLUDES:-}"

if [[ ! -d "${ROOT_DIR}/${DEPLOY_SOURCE}" ]]; then
  echo "Error: source folder not found: ${ROOT_DIR}/${DEPLOY_SOURCE}" >&2
  exit 1
fi

if [[ -z "${DEPLOY_HOST:-}" || -z "${DEPLOY_USER:-}" || -z "${DEPLOY_REMOTE_PATH:-}" ]]; then
  cat >&2 <<'EOF'
Missing required variables.
Set these in .deploy.env or your shell:
  DEPLOY_HOST
  DEPLOY_USER
  DEPLOY_REMOTE_PATH
EOF
  exit 1
fi

DELETE_FLAG=""
if [[ "${1:-}" == "--delete" ]]; then
  DELETE_FLAG="1"
fi

LOCAL="${ROOT_DIR}/${DEPLOY_SOURCE%/}/"
REMOTE_BASE="${DEPLOY_REMOTE_PATH%/}"
REMOTE_DIR="${REMOTE_BASE}/${DEPLOY_TARGET_DIR}"

if [[ "${DRY_RUN}" == "1" ]]; then
  echo "Running in DRY_RUN mode (no changes will be made)."
fi

# Files that must never be deployed.
EXCLUDE_PATTERNS=(
  ".DS_Store"
  ".git"
  ".git/**"
  ".secrets"
  ".secrets/**"
  ".deploy.env"
  "deploy.sh"
)

if [[ -n "${DEPLOY_EXCLUDES}" ]]; then
  IFS=',' read -r -a USER_EXCLUDES <<< "${DEPLOY_EXCLUDES}"
  for pattern in "${USER_EXCLUDES[@]}"; do
    pattern="$(echo "${pattern}" | xargs)"
    if [[ -n "${pattern}" ]]; then
      EXCLUDE_PATTERNS+=("${pattern}")
    fi
  done
fi

case "${DEPLOY_METHOD}" in
  ssh)
    DEPLOY_PORT="${DEPLOY_PORT:-22}"
    if [[ ! -f "${DEPLOY_KEY}" ]]; then
      echo "Error: SSH key not found: ${DEPLOY_KEY}" >&2
      exit 1
    fi

    RSYNC_DRY=""
    RSYNC_DELETE=""
    if [[ "${DRY_RUN}" == "1" ]]; then
      RSYNC_DRY="--dry-run"
    fi
    if [[ "${DELETE_FLAG}" == "1" ]]; then
      RSYNC_DELETE="--delete"
    fi

    SSH_CMD="ssh -i ${DEPLOY_KEY} -p ${DEPLOY_PORT} -o IdentitiesOnly=yes"
    REMOTE="${DEPLOY_USER}@${DEPLOY_HOST}:${REMOTE_DIR%/}/"

    echo "Deploying via SSH/rsync:"
    echo "  Local:  ${LOCAL}"
    echo "  Remote: ${REMOTE}"
    echo "  Port:   ${DEPLOY_PORT}"
    echo "  Key:    ${DEPLOY_KEY}"
    echo

    if [[ "${DRY_RUN}" != "1" ]]; then
      ssh -i "${DEPLOY_KEY}" -p "${DEPLOY_PORT}" -o IdentitiesOnly=yes \
        "${DEPLOY_USER}@${DEPLOY_HOST}" "mkdir -p \"${REMOTE_DIR}\""
    fi

    RSYNC_EXCLUDES=()
    for pattern in "${EXCLUDE_PATTERNS[@]}"; do
      RSYNC_EXCLUDES+=(--exclude "$pattern")
    done

    rsync -azv ${RSYNC_DRY} ${RSYNC_DELETE} \
      "${RSYNC_EXCLUDES[@]}" \
      -e "${SSH_CMD}" \
      "${LOCAL}" "${REMOTE}"
    ;;

  ftp)
    DEPLOY_PORT="${DEPLOY_PORT:-21}"
    if ! command -v lftp >/dev/null 2>&1; then
      echo "Error: lftp is required for ftp mode. Install it first (e.g. brew install lftp)." >&2
      exit 1
    fi

    DEPLOY_PASS="${DEPLOY_PASS:-}"
    if [[ -z "${DEPLOY_PASS}" ]]; then
      read -r -s -p "FTP password for ${DEPLOY_USER}@${DEPLOY_HOST}: " DEPLOY_PASS
      echo
    fi
    if [[ -z "${DEPLOY_PASS}" ]]; then
      echo "Error: empty FTP password." >&2
      exit 1
    fi

    LFTP_DRY=""
    LFTP_DELETE=""
    if [[ "${DRY_RUN}" == "1" ]]; then
      LFTP_DRY="--dry-run"
    fi
    if [[ "${DELETE_FLAG}" == "1" ]]; then
      LFTP_DELETE="--delete"
    fi

    VERIFY_CERT="true"
    if [[ "${DEPLOY_INSECURE}" == "1" ]]; then
      VERIFY_CERT="false"
    fi

    echo "Deploying via FTP/FTPS (explicit TLS):"
    echo "  Local:  ${LOCAL}"
    echo "  Remote: ${DEPLOY_USER}@${DEPLOY_HOST}:${REMOTE_DIR%/}/"
    echo "  Port:   ${DEPLOY_PORT}"
    echo

    LFTP_EXCLUDES=()
    for pattern in "${EXCLUDE_PATTERNS[@]}"; do
      LFTP_EXCLUDES+=(--exclude-glob "$pattern")
    done

    lftp -u "${DEPLOY_USER},${DEPLOY_PASS}" -p "${DEPLOY_PORT}" "${DEPLOY_HOST}" <<EOF
set ftp:ssl-force true
set ftp:ssl-protect-data true
set ssl:verify-certificate ${VERIFY_CERT}
set net:max-retries 2
set net:timeout 20
set cmd:fail-exit true
mirror -R ${LFTP_DRY} ${LFTP_DELETE} --verbose \
  ${LFTP_EXCLUDES[*]} \
  "${LOCAL}" "${REMOTE_DIR%/}/"
bye
EOF
    ;;

  *)
    echo "Error: unsupported DEPLOY_METHOD='${DEPLOY_METHOD}'. Use 'ssh' or 'ftp'." >&2
    exit 1
    ;;
esac

echo
echo "Deploy complete."
