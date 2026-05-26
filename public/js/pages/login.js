const form = document.getElementById('login_form');
const message_user=document.getElementById('message__invalid_credentials');

form.addEventListener('submit', async (e) => {
  e.preventDefault();

  if (!form.checkValidity()) {
    form.reportValidity();
    return;
  }

  const data = Object.fromEntries(new FormData(form));

  try {
    const res = await apiFetch('/api/auth/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data),
    });
    const json = await res.json();
    if (!res.ok) {
        message_user.textContent=json.error.message;
        message_user.classList.add("error__message");
    }
    else{
      message_user.textContent="";
      const flagHasToChangePassword=json.success.must_change_password;
      if(flagHasToChangePassword=="true")
      {
          window.location.href = '/changePassword.php';
      }
      message_user.classList.remove("error__message");
      window.location.href = '/home.php';
    }
       
  } catch (err) {
    console.error(err);
  }
});