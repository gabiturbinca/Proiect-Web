const params = new URLSearchParams(window.location.search);
const giftId = params.get('gift_id');

async function getGift(id) {
    const res = await fetch(`/api/gifts/${id}`);
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
        container.innerHTML = '<p>Cadou inexistent.</p>';
        return;
    }
    try {
        const gift = await getGift(giftId);
        console.log(gift)
        container.replaceChildren(buildGiftCard(gift));
    } catch (err) {
        console.error(err);
        container.innerHTML = '<p>Nu am putut incarca cadoul!</p>';
    }
}

renderGift();