(() => {
  const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  const createHeroParticles = () => {
    const layer = document.getElementById('hero-particles');
    if (!layer) return;

    const shapes = ['sphere', 'triangle', 'diamond'];
    const particleCount = window.innerWidth < 800 ? 18 : 30;

    for (let i = 0; i < particleCount; i += 1) {
      const particle = document.createElement('span');
      const shape = shapes[Math.floor(Math.random() * shapes.length)];

      particle.className = `hero-particle ${shape}`;
      particle.style.left = `${Math.random() * 100}%`;
      particle.style.top = `${Math.random() * 100}%`;
      particle.style.setProperty('--size', `${Math.floor(Math.random() * 18) + 10}px`);
      particle.style.setProperty('--duration', `${Math.floor(Math.random() * 10) + 10}s`);
      particle.style.setProperty('--delay', `${(Math.random() * -12).toFixed(2)}s`);
      particle.style.setProperty('--drift-x', `${Math.floor(Math.random() * 80) - 40}px`);
      particle.style.setProperty('--drift-y', `${Math.floor(Math.random() * 70) - 35}px`);
      particle.style.setProperty('--rotate', `${Math.floor(Math.random() * 360)}deg`);
      layer.appendChild(particle);
    }
  };

  if (!reducedMotion) {
    createHeroParticles();
  }

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
