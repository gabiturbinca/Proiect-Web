const params = new URLSearchParams(window.location.search);
const giftId = params.get('gift_id');

async function getGift(id) {
    const res = await apiFetch(`/api/gifts/${id}`);
    if (!res.ok) throw new Error("Couldn't fetch the gift!");
    const rez = await res.json();
    return rez.success;
}


function buildGiftCard(gift) {
    const template = document.getElementById('gift__card');
    const card = template.content.cloneNode(true);

    card.querySelector('.gift__title').textContent = gift.name;

    const img = card.querySelector('.gift__image');
    img.src = gift.image_url;
    img.alt = gift.name;

    card.querySelector('.gift__description').textContent = gift.description ?? '';
    card.querySelector('.gift__price').textContent = gift.price;
    card.querySelector('.gift__brand').textContent = gift.brand_name ?? '-';
    card.querySelector('.gift__category').textContent = gift.category_name ?? '-';

    const tagsBox = card.querySelector('.gift__tags');
    if (gift.tags) {
        for (const tag of gift.tags) {
            const p = document.createElement('p');
            p.textContent = tag.name;
            tagsBox.append(p);
        }
    }

    return card;
}

async function renderGift() {
    const container = document.getElementById('gift__container');
    if (!giftId) {
        container.innerHTML = '<p>Gift does not exist.</p>';
        return;
    }
    try {
        const gift = await getGift(giftId);
        console.log(gift)
        container.replaceChildren(buildGiftCard(gift));
    } catch (err) {
        console.error(err);
        container.innerHTML = '<p>We could not load the gift!</p>';
    }
}

renderGift();

const form = document.getElementById("order__form");

form.addEventListener("submit", async (e) => {
    e.preventDefault();
    const formData = new FormData(form);
    const formObject = Object.fromEntries(formData);

    if(formObject.is_anonymous==="true")
        formObject.is_anonymous=true;
    else
        formObject.is_anonymous=false;

    formObject.gift_id= giftId;
    try{
        const sendCommand= await apiFetch("/api/orders",{
            method:"POST",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formObject),
        });
        const result=await sendCommand.json();
        const message__command = document.getElementById("message__command");

        if(sendCommand.ok){
            message__command.textContent="Order successful.";
            message__command.classList.remove("error__message");
            message__command.classList.add("success__messsage");
        }
        else{
            message__command.textContent="Order could not be placed. Please try again later!";
            message__command.classList.remove("success__messsage");
            message__command.classList.add("error__message");
        }
        
    }
    catch{
        console.log("Error sending the gift");
    }
});



