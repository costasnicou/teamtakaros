// Keep the menu usable without JavaScript; enhance it once the controls exist.
(() => {
  const header = document.querySelector('.site-header');
  const toggle = header?.querySelector('.menu-toggle');
  const nav = header?.querySelector('.main-nav');
  if (!toggle || !nav) return;

  const compact = window.matchMedia('(max-width: 1199px)');
  const setOpen = (open) => {
    toggle.setAttribute('aria-expanded', String(open));
    toggle.setAttribute('aria-label', open ? 'Κλείσιμο μενού' : 'Άνοιγμα μενού');
    nav.classList.toggle('is-open', open);
    nav.inert = compact.matches && !open;
  };

  document.documentElement.classList.add('navigation-ready');
  setOpen(false);
  toggle.addEventListener('click', () => setOpen(toggle.getAttribute('aria-expanded') !== 'true'));
  nav.addEventListener('click', (event) => {
    if (!compact.matches || !event.target.closest('a')) return;
    toggle.focus({ preventScroll: true });
    setOpen(false); // Native anchor scrolling uses the existing smooth-scroll offset.
  });
  header.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
      setOpen(false);
      toggle.focus({ preventScroll: true });
    }
  });
  document.addEventListener('click', (event) => {
    if (compact.matches && !header.contains(event.target)) setOpen(false);
  });
  compact.addEventListener('change', () => {
    if (compact.matches && nav.contains(document.activeElement)) toggle.focus({ preventScroll: true });
    setOpen(false);
  });
})();

// Keep shared controls safe on pages without the homepage gallery.
(() => {
  const trigger = document.querySelector('.scrollTopTrigger');
  const topLink = document.querySelector('.to-top-link');
  if (trigger && topLink) {
    topLink.addEventListener('click', (event) => {
      event.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => topLink.classList.toggle('hidden', !entry.isIntersecting));
    });
    observer.observe(trigger);
  }
  const year = document.querySelector('.date');
  if (year) year.textContent = new Date().getFullYear();
})();
