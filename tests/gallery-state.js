/* Dependency-free interaction checks. Call exported function with gallery.js source.
 * Uses a small DOM fixture; these checks do not replace visual browser testing.
 */
module.exports = async function testGallery(source) {
  const checks = [];
  const check = (value, label) => { if (!value) throw new Error(label); checks.push(label); };
  let document;
  class Element {
    constructor(kind, dataset = {}) {
      this.kind = kind; this.dataset = dataset; this.children = []; this.parent = null;
      this.attrs = {}; this.listeners = {}; this.hidden = false; this.disabled = false;
      this.textContent = ''; this.tabIndex = 0;
      this.classList = { add() {}, remove() {} };
    }
    append(...children) { children.forEach((child) => { child.parent = this; this.children.push(child); }); return this; }
    setAttribute(name, value) { this.attrs[name] = value; }
    getAttribute(name) { return this.attrs[name]; }
    removeAttribute(name) { delete this.attrs[name]; }
    addEventListener(name, cb) { (this.listeners[name] ||= []).push(cb); }
    dispatch(name, event) { (this.listeners[name] || []).forEach((cb) => cb(event)); if (this.parent) this.parent.dispatch(name, event); }
    click() { this.dispatch('click', { target: this }); }
    focus() { document.activeElement = this; }
    matches(selector) {
      if (selector === '[role="tablist"]') return this.kind === 'tablist';
      if (selector === '[role="tab"]') return ['parent', 'child'].includes(this.kind);
      const mappings = { '[data-gallery-parent]': 'parent', '[data-gallery-group]': 'group', '[data-gallery-child]': 'child', '[data-gallery-collection]': 'panel', '.project-grid': 'grid', '.gallery-status': 'status', '.gallery-load-more': 'more', '[data-photo]': 'photo', '#photo-dialog': 'dialog', '.close': 'close', 'img': 'image' };
      if (selector === 'button') return ['parent', 'child', 'more', 'photo', 'close'].includes(this.kind);
      return mappings[selector] === this.kind;
    }
    closest(selector) { return this.matches(selector) ? this : this.parent?.closest(selector); }
    querySelectorAll(selector) {
      const matches = [];
      const walk = (node) => node.children.forEach((child) => { if (child.matches(selector)) matches.push(child); walk(child); });
      walk(this); return matches;
    }
    querySelector(selector) { return this.querySelectorAll(selector)[0] || null; }
    replaceChildren() { this.children = []; }
    insertAdjacentHTML(position, html) {
      for (const match of html.matchAll(/data-photo-id="(\d+)"/g)) {
        const article = new Element('project', { photoId: match[1] });
        article.append(new Element('photo', { photo: 'image-' + match[1], alt: 'Alt' }));
        this.append(article);
      }
    }
    showModal() { this.open = true; }
    close() { this.open = false; this.dispatch('close', { target: this }); }
  }
  const all = new Map();
  const gallery = new Element('gallery', { endpoint: 'http://localhost/gallery' });
  const parentList = new Element('tablist'); gallery.append(parentList);
  const createParent = (id, childIds) => {
    const button = new Element('parent', { galleryParent: id });
    button.setAttribute('aria-controls', 'group-' + id);
    button.setAttribute('aria-selected', String(id === 'P1'));
    const group = new Element('group', { galleryGroup: id }); group.hidden = id !== 'P1';
    all.set('group-' + id, group); parentList.append(button); gallery.append(group);
    const list = new Element('tablist'); group.append(list);
    const children = childIds.map((childId, index) => {
      const tab = new Element('child', { galleryChild: childId });
      tab.setAttribute('aria-controls', 'panel-' + childId); tab.setAttribute('aria-selected', String(index === 0));
      const panel = new Element('panel', { galleryCollection: childId, page: '1', total: '9' }); panel.hidden = index !== 0;
      const grid = new Element('grid'), status = new Element('status'), more = new Element('more');
      panel.append(grid, status, more); list.append(tab); group.append(panel); all.set('panel-' + childId, panel);
      return { tab, panel, grid, status, more };
    });
    return { button, group, children };
  };
  const p1 = createParent('P1', ['A', 'B']), p2 = createParent('P2', ['C']);
  const [a, b] = p1.children, [c] = p2.children;
  const markup = (ids) => ids.map((id) => `<article data-photo-id="${id}"></article>`).join('');
  a.grid.insertAdjacentHTML('beforeend', markup([1, 2, 3, 4]));
  const dialog = new Element('dialog'); dialog.append(new Element('close'), new Element('image')); gallery.append(dialog);
  const baseQuery = gallery.querySelector.bind(gallery);
  gallery.querySelector = (selector) => selector.includes(':not([hidden])') ? a.panel : baseQuery(selector);
  document = { querySelector: () => gallery, getElementById: (id) => all.get(id), activeElement: null, body: new Element('body') };
  const requests = [];
  const fetch = (url, options) => new Promise((resolve) => { requests.push({ params: url.params, options, resolve }); });
  class URLStub { constructor() { this.params = {}; this.searchParams = { set: (key, value) => { this.params[key] = value; } }; } }
  class AbortStub { constructor() { this.signal = { aborted: false }; } abort() { this.signal.aborted = true; } }
  const settle = async () => { for (let i = 0; i < 8; i++) await Promise.resolve(); };
  const reply = async (request, ids, total, hasMore, ok = true) => {
    request.resolve({ ok, json: async () => ({ html: markup(ids), page: Number(request.params.page), total, hasMore }) });
    await settle();
  };
  new Function('document', 'window', 'fetch', 'URL', 'AbortController', source)(document, { location: { href: 'http://localhost/' } }, fetch, URLStub, AbortStub);
  a.more.focus(); a.more.click(); a.more.click();
  check(requests.length === 1 && requests[0].params.tab === 'A' && requests[0].params.page === '2', 'Load more requests only the active tab; duplicate clicks are blocked');
  await reply(requests[0], [5, 6, 7, 8], 9, true);
  check(a.grid.children.length === 8 && !a.more.hidden, 'Second page appends four images');
  a.more.focus(); a.more.click(); await reply(requests[1], [9], 9, false);
  check(a.grid.children.length === 9 && a.more.hidden && document.activeElement.kind === 'photo', 'Final page hides button and preserves keyboard focus');
  b.tab.click(); await reply(requests[2], [101, 102], 2, false);
  check(b.grid.children.length === 2 && a.panel.hidden && !b.panel.hidden, 'Child tabs switch independently');
  a.tab.click(); check(a.grid.children.length === 0 && requests[3].params.page === '1', 'Returning to a child resets pagination');
  await reply(requests[3], [1, 2, 3, 4], 9, true);
  check(a.grid.children.length === 4, 'Returning collection contains exactly four photos');
  p2.button.click(); const stale = requests[4];
  p1.button.click(); const current = requests[5];
  check(stale.options.signal.aborted && current.params.tab === 'A' && current.params.page === '1', 'Parent switch cancels in-flight requests and resets to its first child');
  await reply(current, [1, 2, 3, 4], 9, true); await reply(stale, [201, 202], 2, false);
  check(c.grid.children.length === 0 && a.grid.children.length === 4 && p2.group.hidden, 'Late responses cannot contaminate another tab');
  b.tab.click(); await reply(requests[6], [], 0, false, false);
  check(b.more.dataset.retryPage === '1' && !b.more.disabled && !b.more.hidden, 'Request failures expose a retry action');
  b.more.click(); check(requests[7].params.page === '1', 'Retry requests the failed page');
  await reply(requests[7], [], 0, false);
  check(b.grid.children.length === 0 && b.more.hidden && b.status.textContent.includes('Δεν υπάρχουν'), 'Empty collections show an empty state without Load more');
  let prevented = false;
  p1.button.dispatch('keydown', { target: p1.button, key: 'ArrowRight', preventDefault() { prevented = true; } });
  check(prevented && document.activeElement === p2.button && p2.button.getAttribute('aria-selected') === 'true', 'Keyboard arrows select tabs at their own level');
  await reply(requests[8], [201], 1, false);
  c.grid.children[0].querySelector('button').click();
  check(dialog.open && dialog.querySelector('img').src === 'image-201', 'Dynamically loaded images open the photo dialog');
  dialog.querySelector('.close').click();
  check(!dialog.open && document.activeElement === c.grid.children[0].querySelector('button'), 'Closing dialog restores focus to its image');
  return checks;
};
