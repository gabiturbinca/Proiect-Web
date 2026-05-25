const psw = document.getElementById('password');
const confirm = document.getElementById('password_confirmation');
const message_register=document.getElementById('message__register');
const message_username=document.getElementById('message__username');
const message_email=document.getElementById('message__email');

function check() {
    confirm.setCustomValidity(
        confirm.value && confirm.value !== psw.value ? 'Passwords are not the same.' : ''
    );
}

psw.addEventListener('input', check);
confirm.addEventListener('input', check);

const form = document.getElementById('register_form');

form.addEventListener('submit', async (e) => {
  e.preventDefault();

  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }
  const data = Object.fromEntries(new FormData(form));

  try {
    const res = await apiFetch('/api/auth/register', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data),
    });
    const result = await res.json();
    if (!res.ok){
      //filtrez dupa tipul de eroare
      console.log(result.error);
      console.log(result.error.errors);
      if(result.error.errors.username){
          message_username.textContent=result.error.errors.username[0];
          message_username.classList.add("error__message");
      }
      else{
         message_username.textContent="";
         message_username.classList.remove("error__message");
      }
      if(result.error.errors.email){
        message_email.textContent=result.error.errors.email[0];
        message_email.classList.add("error__message");
      }
      else{
          message_email.textContent="";
          message_email.classList.remove("error__message");
      }
      message_register.textContent="";
      message_register.classList.remove("success__messsage");
     }
    else{
       message_register.textContent="Register successful. Please go to the login page.";
       message_register.classList.add("success__messsage");
       message_email.textContent="";
       message_username.textContent="";
       message_email.classList.remove("error__message");
       message_username.classList.remove("error__message");
    }
        
  } catch (err) {
    console.error(err);
  }
});