const toggle = document.querySelector('.navbar__toggle');
const menu   = document.getElementById('primary-menu');

toggle?.addEventListener('click', () => {
  const isOpen = menu.classList.toggle('is-open');
  toggle.setAttribute('aria-expanded', String(isOpen));
  toggle.setAttribute('aria-label', isOpen ? 'Închide meniul' : 'Deschide meniul');
});


const logout = document.getElementById("navbara3");
if(document.getElementById("navbara3").textContent=="Logout"){
    logout.addEventListener("click", async (e) => {
    e.preventDefault();                       
    await fetch("/api/auth/logout",
      { method: "POST" }
      );
    window.location.href = "/home.php";      
  });
}
