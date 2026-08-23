document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
  const header = document.querySelector('.site-header');
  const menuToggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.main-nav');
  const cartDrawer = document.querySelector('.cart-drawer');
  const backdrop = document.querySelector('.drawer-backdrop');

  window.addEventListener('scroll', () => header?.classList.toggle('scrolled', window.scrollY > 20), { passive: true });

  menuToggle?.addEventListener('click', () => {
    const open = menuToggle.getAttribute('aria-expanded') === 'true';
    menuToggle.setAttribute('aria-expanded', String(!open));
    nav?.classList.toggle('open', !open);
    body.style.overflow = open ? '' : 'hidden';
  });

  nav?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => {
    nav.classList.remove('open');
    menuToggle?.setAttribute('aria-expanded', 'false');
    body.style.overflow = '';
  }));

  const revealItems = document.querySelectorAll('.fade-in');
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -30px' });
    revealItems.forEach((item) => observer.observe(item));
  } else {
    revealItems.forEach((item) => item.classList.add('visible'));
  }

  document.querySelectorAll('.faq-question').forEach((question) => question.addEventListener('click', () => {
    const item = question.closest('.faq-item');
    const wasOpen = item.classList.contains('open');
    item.closest('.faq-list').querySelectorAll('.faq-item').forEach((element) => element.classList.remove('open'));
    item.classList.toggle('open', !wasOpen);
  }));

  document.querySelectorAll('.filter-btn').forEach((button) => button.addEventListener('click', () => {
    document.querySelectorAll('.filter-btn').forEach((filterButton) => filterButton.classList.remove('active'));
    button.classList.add('active');
    document.querySelectorAll('.catalog-grid .product-card').forEach((card) => {
      card.classList.toggle('hidden', button.dataset.filter !== 'all' && card.dataset.category !== button.dataset.filter);
    });
  }));

  const openCart = () => {
    cartDrawer?.classList.add('open');
    backdrop?.classList.add('open');
    cartDrawer?.setAttribute('aria-hidden', 'false');
    body.style.overflow = 'hidden';
  };
  const closeCart = () => {
    cartDrawer?.classList.remove('open');
    backdrop?.classList.remove('open');
    cartDrawer?.setAttribute('aria-hidden', 'true');
    body.style.overflow = '';
  };

  document.querySelectorAll('.cart-trigger').forEach((button) => button.addEventListener('click', openCart));
  document.querySelector('.cart-close')?.addEventListener('click', closeCart);
  backdrop?.addEventListener('click', closeCart);
  document.addEventListener('keydown', (event) => { if (event.key === 'Escape') closeCart(); });

  document.querySelectorAll('.quantity').forEach((quantity) => {
    const input = quantity.querySelector('input.qty');
    if (!input) return;
    quantity.querySelector('.qty-minus')?.addEventListener('click', () => {
      input.value = Math.max(Number(input.min || 1), Number(input.value) - 1);
      input.dispatchEvent(new Event('change', { bubbles: true }));
    });
    quantity.querySelector('.qty-plus')?.addEventListener('click', () => {
      input.value = Math.min(Number(input.max || 99), Number(input.value) + 1);
      input.dispatchEvent(new Event('change', { bubbles: true }));
    });
  });

  if (window.jQuery) {
    window.jQuery(document.body).on('added_to_cart', () => openCart());
  }
});
