const psw = document.getElementById('psw');
const confirm = document.getElementById('psw_confirm');

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
  delete data.psw_confirm;

  try {
    const res = await fetch('/api/auth/register', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(data),
    });
    const json = await res.json();
    if (!res.ok) 
        throw new Error(json.error ?? 'Înregistrare eșuată');

    window.location.href = '/home.php';
  } catch (err) {
    console.error(err);
  }
});