const params = new URLSearchParams(window.location.search);
const giftId = params.get('gift_id');

async function getGift(id) {
    const res = await fetch(`/api/gifts/${id}`);
    if (!res.ok) throw new Error("Couldn't fetch the gift!");
    const rez = await res.json();
    return rez.success;
}

function humanize(key) {
    return key.replace(/_/g, ' ').replace(/^./, c => c.toUpperCase());
}

function createSpecLine(key, value) {
    const tpl = document.getElementById('gift__spec');
    const node = tpl.content.firstElementChild.cloneNode(true);
    node.querySelector('.gift__spec__label').textContent = `${humanize(key)}: `;
    node.querySelector('.gift__spec__value').textContent = String(value);
    return node;
}

function buildGiftCard(gift) {
    const tpl = document.getElementById('gift__card');
    const card = tpl.content.cloneNode(true);

    card.querySelector('.gift__title').textContent = gift.name;

    const img = card.querySelector('.gift__image');
    img.src = gift.image_url;
    img.alt = gift.name;

    card.querySelector('.gift__description').textContent = gift.description ?? '';
    card.querySelector('.gift__price').textContent = gift.price;
    card.querySelector('.gift__brand').textContent = gift.brand_name ?? '-';
    card.querySelector('.gift__category').textContent = gift.category_name ?? '-';

    const specsBox = card.querySelector('.gift__specs');
    if (gift.specifications) {
        for (const [key, value] of Object.entries(gift.specifications)) {
            specsBox.append(createSpecLine(key, value));
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
        container.replaceChildren(buildGiftCard(gift));
    } catch (err) {
        console.error(err);
        container.innerHTML = '<p>Nu am putut incarca cadoul!</p>';
    }
}

renderGift();
