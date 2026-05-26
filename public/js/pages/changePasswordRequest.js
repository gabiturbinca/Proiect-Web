const form = document.querySelector(".request_new_password-form");
const message = document.getElementById("message_");

async function sendRequest(data){
    const URL="/api/auth/password/reset-request";
    const res = await fetch(URL, {
        method:"POST",
        headers:{"Content-Type":"application/json"},
        body:JSON.stringify(data)
    });
    const result = await res.json();
    return result;
}

form.addEventListener("submit", async(e) => {
    e.preventDefault();
    const data = Object.fromEntries(new FormData(form));
    const res = await sendRequest(data);
     if(res.error){
        message.classList.remove(".success__messsage");
        message.classList.add("error__message");
        message.textContent=res.error.message;  
    }

    if(res.success){
        message.classList.remove("error__message");
        message.classList.add(".success__messsage");
        message.textContent=res.success.message;  
    }
});