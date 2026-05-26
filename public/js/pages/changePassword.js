const confirmButton = document.getElementById("change_pass__submit"); 
const form = document.querySelector(".change_password-form");
const oldPassword = document.getElementById("current_password");
const newPassword = document.getElementById("new_password");
const confirmNewPassword=document.getElementById("new_password_confirmation");
const message=document.getElementById("message");

async function changePassword(data){
    const URL = '/api/auth/password';
    const res = await apiFetch(URL, {
        method:"POST",
        headers:{"Content-Type": "application/json"},
        body:JSON.stringify(data)
    });
    const result = await res.json();
    return result;
}

function check() {
    confirmNewPassword.setCustomValidity(
        confirmNewPassword.value && confirmNewPassword.value !== newPassword.value ? 'Passwords are not the same.' : ''
    );
}

form.addEventListener("submit", async(e) => {
    e.preventDefault();
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }
    const data = Object.fromEntries(new FormData(form));
    const res = await changePassword(data);
    if(res.error){
        message.textContent=res.error.message;  
        message.classList.remove(".success__messsage");
        message.classList.add("error__message");
    }
    if(res.success){
        message.textContent=res.success.message;  
        message.classList.remove("error__message");
        message.classList.add(".success__messsage");
        
    }
         
});