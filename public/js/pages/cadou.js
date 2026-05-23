const params = new URLSearchParams(window.location.search);
const giftId = params.get('gift_id');
const prevBtn = document.getElementById("btn__prev");
const nextBtn = document.getElementById("btn__next");

const prevBtnComm = document.getElementById("btn__prev_comm");
const nextBtnComm = document.getElementById("btn__next_comm");

const elemNumber = 5;
let currentPage = 1;

let currentPageReviews=1;

async function getGift(id) {
    const res = await apiFetch(`/api/gifts/${id}`);
    if (!res.ok) throw new Error("Couldn't fetch the gift!");
    const rez = await res.json();
    return rez.success;
}

async function getRelatedGifts(id,page){
    const res = await apiFetch(`/api/gifts/${id}/related?pageNumber=${page}&elemNumber=${elemNumber}`);
    if (!res.ok) 
        throw new Error("Couldn't fetch the related gifts!");
    const rez = await res.json();
    return rez.success;
}


async function getReviews(id, page){
    const res = await apiFetch(`/api/gifts/${id}/reviews?pageNumber=${page}&elemNumber=${elemNumber}`);
    if(!res.ok)
        throw new Error("Couldn't fetch the reviews!");
    const rez = await res.json();
    console.log(rez.success);
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

    const tagsBox = card.querySelector('.gift__tags');
    if (gift.tags) {
        for (const tag of gift.tags) {
            const p = document.createElement('p');
            p.textContent = tag.name;
            tagsBox.append(p);
        }
    }

    card.querySelector('#send__gift').addEventListener('click', () => {
        window.location.href = `/comanda.php?gift_id=${giftId}`;
    });

    return card;
}


function buildRelatedGiftsCard(gift){
    const template = document.getElementById("result__gift");
    const card = template.content.firstElementChild.cloneNode(true);
    card.querySelector('.card__title').textContent = gift.name;
    const img = card.querySelector('.card__image');
    img.src = gift.image_url;
    img.alt = gift.name;
    card.querySelector('.card__description').textContent = "Description : " + gift.description;
    card.querySelector('.card__price').textContent = "Price : " + gift.price;
    card.querySelector('.card__brand').textContent = "Brand : " + gift.brand_name;
    card.querySelector('.card__category').textContent = "Category : " + gift.category_name;

    return card;

}

function buildReviews(review){
    const template = document.getElementById("review");
    const card = template.content.firstElementChild.cloneNode(true);
    card.querySelector('.reviewer_name').textContent=review.username;
    card.querySelector('.comment').textContent=review.comment;
    
    const rating = Math.round(review.rating * 2);
    const idRating = "rating" + rating;
    const inputs = card.querySelectorAll('.rate input');
    const labels = card.querySelectorAll('.rate label');
    inputs.forEach(input => {
        input.name = "rating_" + review.id;

        const oldIdInput = input.id;
        const newId = oldIdInput + "_" + review.id;
        input.id= newId;
        const associatedFor=document.querySelector(`label[for=${oldIdInput}]`);
        if(associatedFor)
            associatedFor.setAttribute("for", newId);
         
        if(oldIdInput==idRating)
            input.checked=true;

    });
    return card;
}

async function renderComments(page){
    const container = document.querySelector(".reviews_container");
    try{
        const {reviews, reviews_count} = await getReviews(giftId,page);
        const totalPages = Math.ceil(reviews_count/elemNumber);
        if(page < 1) return;
        if(page==1) 
            prevBtnComm.disabled=true;
        else
            prevBtnComm.disabled=false;
        if(page == totalPages)
            nextBtnComm.disabled=true;
        else
            nextBtnComm.disabled=false;
        const reviewCards = reviews.map(buildReviews);      
        container.replaceChildren(...reviewCards);  
    }
    catch{
        container.innerHTML="<p>Couldn't load reviews!</p>";
    }
}
async function renderRelatedGifts(page){
    const container = document.getElementById("related_gifts");
    try{
        const {gifts, gifts_count} = await getRelatedGifts(giftId,page);
        const totalPages = Math.ceil(gifts_count/elemNumber);
        if(page < 1) return;
        if(page==1) 
            prevBtn.disabled=true;
        else
            prevBtn.disabled=false;
        if(page == totalPages)
            nextBtn.disabled=true;
        else
            nextBtn.disabled=false;
        const giftCards = gifts.map(buildRelatedGiftsCard);      
        container.replaceChildren(...giftCards);    
    }
    catch{
        container.innerHTML="<p>Couldn't load related presents!</p>";
    }
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

renderRelatedGifts(currentPage);

renderComments(currentPageReviews);

prevBtn.addEventListener("click", async(e) =>{
    currentPage=-1;
    renderRelatedGifts(currentPage);
});

nextBtn.addEventListener("click", async(e) =>{
    currentPage=+1;
    renderRelatedGifts(currentPage);
});


prevBtnComm.addEventListener("click", async(e) =>{
    currentPageReviews=-1;
    renderComments(currentPageReviews);
});

nextBtnComm.addEventListener("click", async(e) =>{
    currentPageReviews=+1;
    renderComments(currentPageReviews);
});
