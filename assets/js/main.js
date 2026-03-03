(() => {
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const initThemeToggle = () => {
    const root = document.documentElement;
    const toggle = document.querySelector('.theme-toggle');
    const mq = window.matchMedia('(prefers-color-scheme: dark)');
    const defaultTheme = root.dataset.defaultTheme || 'light';

    const resolveTheme = (mode) => {
      if (mode === 'auto') {
        return mq.matches ? 'dark' : 'light';
      }
      return mode === 'dark' ? 'dark' : 'light';
    };

    const applyTheme = (mode) => {
      const resolved = resolveTheme(mode);
      root.setAttribute('data-theme', resolved);
      root.setAttribute('data-theme-mode', mode);
      if (toggle) {
        const sunIcon = toggle.querySelector('.sun');
        const moonIcon = toggle.querySelector('.moon');
        if (sunIcon && moonIcon) {
          if (resolved === 'dark') {
            sunIcon.style.display = 'none';
            moonIcon.style.display = 'inline';
          } else {
            sunIcon.style.display = 'inline';
            moonIcon.style.display = 'none';
          }
        }
      }
    };

    const saved = localStorage.getItem('visitfy-theme');
    const initialMode = saved || defaultTheme;
    applyTheme(initialMode);

    if (toggle) {
      toggle.addEventListener('click', () => {
        const current = root.getAttribute('data-theme') || 'light';
        const nextMode = current === 'dark' ? 'light' : 'dark';
        localStorage.setItem('visitfy-theme', nextMode);
        applyTheme(nextMode);
      });
    }

    mq.addEventListener('change', () => {
      const mode = localStorage.getItem('visitfy-theme') || defaultTheme;
      if (mode === 'auto') {
        applyTheme('auto');
      }
    });
  };

  const initMobileNav = () => {
    const toggle = document.querySelector('.nav-toggle');
    const nav = document.getElementById('main-nav');
    if (!toggle || !nav) return;

    toggle.addEventListener('click', () => {
      const isOpen = nav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    nav.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', () => {
        nav.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
      });
    });
  };

  const initParticles = () => {
    if (reducedMotion) return;

    const heroAnimation = document.documentElement.dataset.heroAnimation || 'particles';
    const layers = document.querySelectorAll('.particle-layer[data-particles]');
    if (!layers.length) return;

    const shapes = ['sphere', 'triangle', 'diamond'];
    const logoPath = 'assets/images/visitfy-logo.svg';

    layers.forEach((layer) => {
      if (heroAnimation === 'scan' && layer.classList.contains('hero-particles-layer')) {
        return;
      }

      const desired = Number(layer.getAttribute('data-particles') || '20');
      const particleCount = window.innerWidth < 800 ? Math.max(10, Math.floor(desired * 0.6)) : desired;

      for (let i = 0; i < particleCount; i += 1) {
        const particle = document.createElement('span');
        const isLogo = Math.random() < 0.08; // 8% der Partikel sind Logos
        const shape = isLogo ? 'logo' : shapes[Math.floor(Math.random() * shapes.length)];

        particle.className = `particle ${shape}`;
        particle.style.left = `${Math.random() * 100}%`;
        particle.style.top = `${Math.random() * 100}%`;
        
        if (isLogo) {
          const img = document.createElement('img');
          img.src = logoPath;
          img.alt = 'Visitfy Logo';
          img.style.width = '100%';
          img.style.height = '100%';
          img.style.objectFit = 'contain';
          particle.appendChild(img);
          particle.style.setProperty('--size', `${Math.floor(Math.random() * 16) + 28}px`);
        } else {
          particle.style.setProperty('--size', `${Math.floor(Math.random() * 18) + 10}px`);
        }
        
        particle.style.setProperty('--duration', `${Math.floor(Math.random() * 10) + 10}s`);
        particle.style.setProperty('--delay', `${(Math.random() * -12).toFixed(2)}s`);
        particle.style.setProperty('--drift-x', `${Math.floor(Math.random() * 80) - 40}px`);
        particle.style.setProperty('--drift-y', `${Math.floor(Math.random() * 70) - 35}px`);
        particle.style.setProperty('--rotate', `${Math.floor(Math.random() * 360)}deg`);
        layer.appendChild(particle);
      }
    });
  };

  const initCounters = () => {
    const counters = document.querySelectorAll('.counter');
    if (!counters.length) return;

    const animate = (counter) => {
      const target = Number(counter.dataset.target || '0');
      const duration = Number(counter.dataset.duration || '1400');
      const start = performance.now();

      const tick = (now) => {
        const progress = Math.min((now - start) / duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        counter.textContent = Math.floor(target * eased).toLocaleString('de-DE');

        if (progress < 1) {
          requestAnimationFrame(tick);
        } else {
          counter.textContent = target.toLocaleString('de-DE');
        }
      };

      requestAnimationFrame(tick);
    };

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        animate(entry.target);
        obs.unobserve(entry.target);
      });
    }, { threshold: 0.35 });

    counters.forEach((counter) => observer.observe(counter));
  };

  const initLazyMedia = () => {
    const lazyVideos = Array.from(document.querySelectorAll('video.lazy-video'));
    if (!lazyVideos.length) return;

    const loadVideo = (video) => {
      if (video.dataset.loaded === '1') return;
      const source = video.querySelector('source[data-src]');
      if (!source) return;
      const src = source.getAttribute('data-src');
      if (!src) return;
      source.setAttribute('src', src);
      video.load();
      video.dataset.loaded = '1';
    };

    if (!('IntersectionObserver' in window)) {
      lazyVideos.forEach(loadVideo);
      return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        if (el.tagName === 'VIDEO') {
          loadVideo(el);
        }
        obs.unobserve(el);
      });
    }, { threshold: 0.01, rootMargin: '280px 0px' });

    lazyVideos.forEach((video) => observer.observe(video));
  };

  const initScrollReveal = () => {
    const sections = document.querySelectorAll('.anim-section');
    if (!sections.length) return;

    if (reducedMotion || !('IntersectionObserver' in window)) {
      sections.forEach((section) => section.classList.add('is-visible'));
      return;
    }

    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        entry.target.classList.add('is-visible');
        obs.unobserve(entry.target);
      });
    }, { threshold: 0.2, rootMargin: '0px 0px -8% 0px' });

    sections.forEach((section) => observer.observe(section));
  };

  initThemeToggle();
  initMobileNav();
  initParticles();
  initLazyMedia();
  initScrollReveal();
  initCounters();
})();
