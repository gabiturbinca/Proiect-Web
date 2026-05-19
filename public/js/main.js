const toggle = document.querySelector('.navbar__toggle');
const menu   = document.getElementById('primary-menu');

toggle?.addEventListener('click', () => {
  const isOpen = menu.classList.toggle('is-open');
  toggle.setAttribute('aria-expanded', String(isOpen));
  toggle.setAttribute('aria-label', isOpen ? 'Închide meniul' : 'Deschide meniul');
});


const URL= "/api/auth/me";

async function isLoggedIn(){
  try{
     const res = await fetch(URL);
     return res.ok;
  }
  catch{
    return false;
  }
}

async function changeNavbar()
{
   if(!(await isLoggedIn())) return;
   
    document.getElementById("navbara1").textContent = "Comenzile mele";
    document.getElementById("navbara1").href="/comenzileMele.php";

    document.getElementById("navbara2").textContent = "Cauta cadou";
    document.getElementById("navbara2").href="/recomandare.php";

    document.getElementById("navbara3").textContent = "Logout";
    document.getElementById("navbara3").href="#";
}

changeNavbar();