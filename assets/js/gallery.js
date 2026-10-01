(() => {
  const gallery = document.querySelector('[data-work-gallery]');
  if (!gallery) return;

  const parents = [...gallery.querySelectorAll('[data-gallery-parent]')];
  const groups = [...gallery.querySelectorAll('[data-gallery-group]')];
  let activePanel = gallery.querySelector('[data-gallery-group]:not([hidden]) [data-gallery-collection]:not([hidden])');
  let controller = null;
  let requestId = 0;

  const loadLabel = 'Περισσότερες φωτογραφίες +';
  const cancelRequest = () => {
    requestId += 1;
    controller?.abort();
    if (activePanel) {
      activePanel.removeAttribute('aria-busy');
      activePanel.querySelector('.gallery-load-more').disabled = false;
    }
  };

  async function loadPhotos(panel, page) {
    cancelRequest();
    controller = new AbortController();
    const currentController = controller;
    const token = requestId;
    const grid = panel.querySelector('.project-grid');
    const status = panel.querySelector('.gallery-status');
    const button = panel.querySelector('.gallery-load-more');
    const isReset = page === 1;
    panel.setAttribute('aria-busy', 'true');
    button.disabled = true;
    button.textContent = 'Φόρτωση…';
    status.textContent = 'Φόρτωση φωτογραφιών…';
    if (isReset) {
      grid.replaceChildren();
      button.hidden = true;
      panel.dataset.page = '0';
    }
    try {
      const url = new URL(gallery.dataset.endpoint, window.location.href);
      url.searchParams.set('tab', panel.dataset.galleryCollection);
      url.searchParams.set('page', String(page));
      const response = await fetch(url, { signal: currentController.signal, headers: { Accept: 'application/json' } });
      if (!response.ok) throw new Error('Gallery request failed');
      const data = await response.json();
      if (token !== requestId || panel !== activePanel) return;
      if (typeof data.html !== 'string' || !Number.isInteger(data.total) || data.page !== page) {
        throw new Error('Invalid gallery response');
      }
      const previousCount = grid.children.length;
      // Markup is generated and escaped by the same-origin WordPress endpoint.
      grid.insertAdjacentHTML('beforeend', data.html);
      panel.dataset.page = String(page);
      panel.dataset.total = String(data.total);
      delete button.dataset.retryPage;
      button.hidden = !data.hasMore;
      status.textContent = data.total
        ? `${grid.children.length} από ${data.total} φωτογραφίες`
        : 'Δεν υπάρχουν ακόμα φωτογραφίες σε αυτή τη συλλογή.';
      // Keep keyboard focus useful when the button disappears on the final page.
      if (!isReset && document.activeElement === button) {
        grid.children[previousCount]?.querySelector('button')?.focus({ preventScroll: true });
      }
    } catch (error) {
      if (error.name === 'AbortError' || token !== requestId || panel !== activePanel) return;
      status.textContent = 'Δεν ήταν δυνατή η φόρτωση. Δοκιμάστε ξανά.';
      button.dataset.retryPage = String(page);
      button.hidden = false;
    } finally {
      if (token === requestId && panel === activePanel) {
        panel.removeAttribute('aria-busy');
        button.disabled = false;
        button.textContent = button.dataset.retryPage ? 'Δοκιμάστε ξανά' : loadLabel;
      }
    }
  }

  function selectChild(button) {
    const group = button.closest('[data-gallery-group]');
    const target = document.getElementById(button.getAttribute('aria-controls'));
    if (target === activePanel) return;
    cancelRequest();
    group.querySelectorAll('[data-gallery-child]').forEach((tab) => {
      const selected = tab === button;
      tab.setAttribute('aria-selected', String(selected));
      tab.tabIndex = selected ? 0 : -1;
    });
    group.querySelectorAll('[data-gallery-collection]').forEach((panel) => { panel.hidden = panel !== target; });
    activePanel = target;
    loadPhotos(target, 1);
  }

  function selectParent(button) {
    if (button.getAttribute('aria-selected') === 'true') return;
    cancelRequest();
    activePanel = null;
    parents.forEach((tab) => {
      const selected = tab === button;
      tab.setAttribute('aria-selected', String(selected));
      tab.tabIndex = selected ? 0 : -1;
    });
    groups.forEach((group) => { group.hidden = group.dataset.galleryGroup !== button.dataset.galleryParent; });
    const group = document.getElementById(button.getAttribute('aria-controls'));
    const firstChild = group.querySelector('[data-gallery-child]');
    if (firstChild) selectChild(firstChild);
  }

  gallery.addEventListener('click', (event) => {
    const parent = event.target.closest('[data-gallery-parent]');
    const child = event.target.closest('[data-gallery-child]');
    const more = event.target.closest('.gallery-load-more');
    if (parent) selectParent(parent);
    else if (child) selectChild(child);
    else if (more && !more.disabled) {
      const panel = more.closest('[data-gallery-collection]');
      if (panel === activePanel) loadPhotos(panel, Number(more.dataset.retryPage || Number(panel.dataset.page) + 1));
    }
  });

  // Arrow keys, Home, and End operate within either level of tabs.
  gallery.querySelectorAll('[role="tablist"]').forEach((list) => {
    list.addEventListener('keydown', (event) => {
      const tabs = [...list.querySelectorAll('[role="tab"]')];
      const index = tabs.indexOf(event.target);
      if (index < 0) return;
      let next;
      if (event.key === 'ArrowRight') next = (index + 1) % tabs.length;
      else if (event.key === 'ArrowLeft') next = (index - 1 + tabs.length) % tabs.length;
      else if (event.key === 'Home') next = 0;
      else if (event.key === 'End') next = tabs.length - 1;
      else return;
      event.preventDefault();
      tabs[next].focus();
      tabs[next].click();
    });
  });

  const dialog = gallery.querySelector('#photo-dialog');
  if (!dialog) return;
  let opener = null;
  gallery.addEventListener('click', (event) => {
    const photo = event.target.closest('[data-photo]');
    if (!photo) return;
    opener = photo;
    const image = dialog.querySelector('img');
    image.src = photo.dataset.photo;
    image.alt = photo.dataset.alt || '';
    dialog.showModal();
    document.body.classList.add('gallery-dialog-open');
  });
  dialog.querySelector('.close').addEventListener('click', () => dialog.close());
  dialog.addEventListener('click', (event) => {
    if (event.target !== dialog) return;
    const rect = dialog.getBoundingClientRect();
    if (event.clientX < rect.left || event.clientX > rect.right || event.clientY < rect.top || event.clientY > rect.bottom) dialog.close();
  });
  dialog.addEventListener('close', () => {
    document.body.classList.remove('gallery-dialog-open');
    dialog.querySelector('img').removeAttribute('src');
    opener?.focus({ preventScroll: true });
  });
})();
