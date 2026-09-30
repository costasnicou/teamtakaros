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

// 'use strict';
const selectedbtn = document.querySelector('.btnAutoselect');
const trigger = document.querySelector(".scrollTopTrigger");
const topLink = document.querySelector('.to-top-link');

document.addEventListener('DOMContentLoaded',function(){

// console.log(selectedbtn);
  selectedbtn.click();
});


const overlay = document.querySelector('.overlay');
document.querySelectorAll('dialog').forEach(dialog =>  {
    dialog.querySelector('.close').addEventListener('click', function(){
        overlay.classList.add('hidden');     
        dialog.close();
      }
    )

    dialog.addEventListener('click', e =>  {
      if (e.target === dialog)  {
        const r=dialog.getBoundingClientRect();
        if(e.clientX<r.left||e.clientX>r.right||e.clientY<r.top||e.clientY>r.bottom){
          overlay.classList.add('hidden');
          dialog.close();
        }

        
      }
    }
    );

    dialog.addEventListener('keydown', e =>{
      if (e.key === "Escape"){
         overlay.classList.add('hidden');     
        dialog.close();
      }
    })
  }
);

const photoDialog = document.querySelector('#photo-dialog');
document.querySelectorAll('[data-photo]').forEach(button => button.addEventListener('click', () =>  {
  const img = photoDialog.querySelector('img');
  img.src = button.dataset.photo;
  img.alt = button.dataset.caption;
  // document.querySelector('#photo-caption').textContent = button.dataset.caption;
  // document.querySelector('#photo-source').href = button.dataset.source;
  photoDialog.showModal();
  overlay.classList.remove('hidden');
}
));



document.querySelectorAll('[data-filter]').forEach(button => button.addEventListener('click', () =>  {
  document.querySelectorAll('[data-filter]').forEach(b => b.setAttribute('aria-pressed', String(b === button)));
  document.querySelectorAll('[data-category]').forEach(card =>  {
    card.hidden = button.dataset.filter !== 'Όλα' && card.dataset.category !== button.dataset.filter;
  }
  );
}
));

// observer trigger functionality
// const navbar = document.getElementById("navbar");

// topLink.onclick.scrollToTop();
const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach(entry => {
      if (!entry.isIntersecting) {
        // navbar.classList.add("shrink");
          topLink.classList.add("hidden");
          topLink.onclick = e =>{
            e.preventDefault();
            window.scrollTo({
              top: 0,
              behavior: 'smooth'
            });
            selectedbtn.click();
            
          }
      } else {
        // navbar.classList.remove("shrink");
          topLink.classList.remove("hidden");
      }
    });
  },
  { threshold: 0 } // triggers as soon as element leaves the viewport
);

observer.observe(trigger);


const date = new Date();
const htmlYear = document.querySelector('.date');

htmlYear.textContent = date.getFullYear();