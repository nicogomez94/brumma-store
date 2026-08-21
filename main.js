document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
  const header = document.querySelector('.site-header');
  const menuToggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.main-nav');
  const toast = document.querySelector('.toast');
  let toastTimer;

  const showToast = (message) => {
    if (!toast) return;
    toast.textContent = message;
    toast.classList.add('show');
    clearTimeout(toastTimer);
    toastTimer = setTimeout(() => toast.classList.remove('show'), 2500);
  };

  window.addEventListener('scroll', () => header?.classList.toggle('scrolled', window.scrollY > 20), { passive: true });

  menuToggle?.addEventListener('click', () => {
    const open = menuToggle.getAttribute('aria-expanded') === 'true';
    menuToggle.setAttribute('aria-expanded', String(!open));
    nav?.classList.toggle('open', !open);
    body.style.overflow = open ? '' : 'hidden';
  });

  nav?.querySelectorAll('a').forEach(link => link.addEventListener('click', () => {
    nav.classList.remove('open');
    menuToggle?.setAttribute('aria-expanded', 'false');
    body.style.overflow = '';
  }));

  const revealItems = document.querySelectorAll('.fade-in');
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(entries => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -30px' });
    revealItems.forEach(item => observer.observe(item));
  } else {
    revealItems.forEach(item => item.classList.add('visible'));
  }

  document.querySelectorAll('.faq-question').forEach(question => question.addEventListener('click', () => {
    const item = question.closest('.faq-item');
    const wasOpen = item.classList.contains('open');
    item.closest('.faq-list').querySelectorAll('.faq-item').forEach(el => el.classList.remove('open'));
    item.classList.toggle('open', !wasOpen);
  }));

  document.querySelectorAll('.filter-btn').forEach(button => button.addEventListener('click', () => {
    document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');
    const filter = button.dataset.filter;
    document.querySelectorAll('.catalog-grid .product-card').forEach(card => {
      card.classList.toggle('hidden', filter !== 'all' && card.dataset.category !== filter);
    });
  }));

  const cartDrawer = document.querySelector('.cart-drawer');
  const backdrop = document.querySelector('.drawer-backdrop');
  let cart = [];
  try { cart = JSON.parse(localStorage.getItem('brumma-cart')) || []; } catch (_) { cart = []; }

  const money = value => new Intl.NumberFormat('es-AR', { style: 'currency', currency: 'ARS', maximumFractionDigits: 0 }).format(value);
  const saveCart = () => localStorage.setItem('brumma-cart', JSON.stringify(cart));
  const renderCart = () => {
    const itemsNode = document.querySelector('.cart-items');
    const emptyNode = document.querySelector('.cart-empty');
    const summaryNode = document.querySelector('.cart-summary');
    const count = cart.reduce((sum, item) => sum + item.qty, 0);
    document.querySelectorAll('.cart-count').forEach(node => node.textContent = count);
    if (!itemsNode) return;
    itemsNode.innerHTML = cart.map((item, index) => `<div class="cart-item"><div><p>${item.name}</p><small>${item.qty} × ${money(item.price)}</small></div><button class="remove-item" data-index="${index}" aria-label="Quitar ${item.name}"><i class="fa-solid fa-xmark"></i></button></div>`).join('');
    emptyNode?.classList.toggle('hidden', cart.length > 0);
    summaryNode?.classList.toggle('visible', cart.length > 0);
    const total = cart.reduce((sum, item) => sum + item.price * item.qty, 0);
    const totalNode = document.querySelector('.cart-total');
    if (totalNode) totalNode.textContent = money(total);
    document.querySelectorAll('.remove-item').forEach(button => button.addEventListener('click', () => {
      cart.splice(Number(button.dataset.index), 1); saveCart(); renderCart();
    }));
  };
  const openCart = () => { cartDrawer?.classList.add('open'); backdrop?.classList.add('open'); cartDrawer?.setAttribute('aria-hidden','false'); body.style.overflow='hidden'; };
  const closeCart = () => { cartDrawer?.classList.remove('open'); backdrop?.classList.remove('open'); cartDrawer?.setAttribute('aria-hidden','true'); body.style.overflow=''; };
  document.querySelectorAll('.cart-trigger').forEach(button => button.addEventListener('click', openCart));
  document.querySelector('.cart-close')?.addEventListener('click', closeCart);
  backdrop?.addEventListener('click', closeCart);
  document.addEventListener('keydown', e => { if (e.key === 'Escape') closeCart(); });

  const addToCart = (name, price, qty = 1) => {
    const existing = cart.find(item => item.name === name);
    if (existing) existing.qty += qty; else cart.push({ name, price, qty });
    saveCart(); renderCart(); showToast(`${name} se sumó a tu bolsa`);
  };
  document.querySelectorAll('.quick-add, .bundle-add').forEach(button => button.addEventListener('click', () => addToCart(button.dataset.product, Number(button.dataset.price))));

  const qtyInput = document.querySelector('.qty-input');
  document.querySelector('.qty-minus')?.addEventListener('click', () => qtyInput.value = Math.max(1, Number(qtyInput.value) - 1));
  document.querySelector('.qty-plus')?.addEventListener('click', () => qtyInput.value = Math.min(12, Number(qtyInput.value) + 1));
  document.querySelector('.add-detail')?.addEventListener('click', event => addToCart(event.currentTarget.dataset.product, Number(event.currentTarget.dataset.price), Number(qtyInput?.value || 1)));

  const flavorData = {
    limon: { title: 'Espuma Limón', profile: 'Perfil 01 · Cítrico', description: 'Un sabor cítrico y refrescante para coronar tragos, limonadas, cafés fríos y postres.', image: 'FOTOS ERICA ARGENTINA/GS-Sabores_Espuma Sabor Limão.png', bg: '#e2f69a' },
    cereza: { title: 'Espuma Cereza', profile: 'Perfil 02 · Frutal', description: 'Dulce, intensa y de color vibrante. Ideal para cócteles rojos, postres y bebidas cremosas.', image: 'FOTOS ERICA ARGENTINA/GS-Sabores_Espuma Sabor Cereja (1).png', bg: '#f5a9bf' },
    mandarina: { title: 'Espuma Mandarina', profile: 'Perfil 03 · Cítrico', description: 'Jugosa y luminosa, con el dulzor justo para tragos frescos, gaseosas y cafés fríos.', image: 'FOTOS ERICA ARGENTINA/GS-Sabores_Espuma Sabor Tangerina (1).png', bg: '#ffc77a' },
    manzana: { title: 'Espuma Manzana Verde', profile: 'Perfil 04 · Fresco', description: 'Ácida, crocante y muy refrescante. Funciona en cócteles, limonadas y preparaciones sin alcohol.', image: 'FOTOS ERICA ARGENTINA/GS-Sabores_Espuma Sabor Maçã Verde (1).png', bg: '#c9ef7c' },
    frutilla: { title: 'Espuma Frutilla', profile: 'Perfil 05 · Goloso', description: 'Frutal y cremosa, pensada para milkshakes, postres, tragos dulces y helados.', image: 'FOTOS ERICA ARGENTINA/GS-Sabores_Espuma Sabor Morango (1).png', bg: '#ffc0ca' },
    sandia: { title: 'Espuma Sandía', profile: 'Perfil 06 · Refrescante', description: 'Liviana, fresca y divertida. Una aliada para bebidas de verano y preparaciones frutales.', image: 'FOTOS ERICA ARGENTINA/GS-Sabores_Espuma Sabor Melancia.png', bg: '#ffaca4' },
    'frutos-rojos': { title: 'Espuma Frutos Rojos', profile: 'Perfil 07 · Intenso', description: 'Una mezcla frutal profunda para cócteles, espumantes, postres y bebidas con mucho color.', image: 'FOTOS ERICA ARGENTINA/GS-Sabores_Espuma Sabor Frutas Vermelhas (1).png', bg: '#ff9e87' },
    jengibre: { title: 'Espuma Jengibre', profile: 'Perfil 08 · Especiado', description: 'Cálida y especiada. Ideal para sumar carácter a tragos cítricos, cafés y recetas de autor.', image: 'FOTOS ERICA ARGENTINA/gs-espumas-pequenas_0001s_0002_GENGIBRE.png', bg: '#f1b17e' }
  };
  const selectFlavor = key => {
    const data = flavorData[key] || flavorData.limon;
    const title = document.querySelector('.dynamic-title'); const profile = document.querySelector('.dynamic-profile'); const description = document.querySelector('.dynamic-description'); const detailArt = document.querySelector('.detail-art'); const detailImage = document.querySelector('.dynamic-image'); const addButton = document.querySelector('.add-detail'); const breadcrumb = document.querySelector('.breadcrumb span');
    if (title) title.textContent = data.title; if (profile) profile.textContent = data.profile; if (description) description.textContent = data.description; if (detailArt) detailArt.style.background = data.bg; if (detailImage) { detailImage.src = data.image; detailImage.alt = data.title; } if (addButton) addButton.dataset.product = data.title; if (breadcrumb) breadcrumb.textContent = data.title; if (title) document.title = `${data.title} — Producto`;
    document.querySelectorAll('.flavor-option').forEach(button => button.classList.toggle('active', button.dataset.flavor === key));
  };
  document.querySelectorAll('.flavor-option').forEach(button => button.addEventListener('click', () => selectFlavor(button.dataset.flavor)));
  const requestedFlavor = new URLSearchParams(window.location.search).get('flavor');
  if (requestedFlavor && flavorData[requestedFlavor]) selectFlavor(requestedFlavor);

  document.querySelector('.checkout-demo')?.addEventListener('click', () => showToast('El checkout se conectará en la versión final'));
  renderCart();
});
