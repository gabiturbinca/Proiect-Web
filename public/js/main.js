const toggle = document.querySelector('.navbar__toggle');
const menu   = document.getElementById('primary-menu');

toggle?.addEventListener('click', () => {
  const isOpen = menu.classList.toggle('is-open');
  toggle.setAttribute('aria-expanded', String(isOpen));
  toggle.setAttribute('aria-label', isOpen ? 'Închide meniul' : 'Deschide meniul');
});





