(() => {
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
})();
