const params = new URLSearchParams(window.location.search);
const categoryId = params.get('category_id');
const perPage = 10;
let currentPage=1;

async function getGifts(page){
    let CATEGORIES_GIFTS_URL=`/api/gifts/category/${categoryId}?pageNumber=${page}&elemNumber=${perPage}`;
    const response = await fetch(CATEGORIES_GIFTS_URL);
    if(!response.ok)
        throw new Error("Couldn't fetch the gifts for this category!");
    const rez = await response.json();
    return rez.success;
}

function createGiftCard(gift){
    const template = document.getElementById("result__gift");
    const card = template.content.firstElementChild.cloneNode(true);

    card.href=`/cadou.php?gift_id=${gift.id}`;
    card.querySelector('.card__image').src=gift.image_url;
    card.querySelector('.card__image').alt=gift.name;
    card.querySelector('.card__title').textContent=gift.name;
    card.querySelector('.card__desc__gift').textContent=gift.description;
    card.querySelector('.card__price__gift').textContent="Preț : "+ gift.price;

    return card;
}

async function renderGiftPage(page){
    if(page<1) return;
    const giftBox = document.getElementById("result__gifts");
    const nextBtn = document.getElementById("btn__next");
    const prevBtn = document.getElementById("btn__prev");

    try{
        const { gifts, gifts_count } = await getGifts(page);
        const totalPages = Math.ceil(gifts_count / perPage);
        if(page > totalPages && totalPages > 0) return;

        currentPage = page;
        const giftCards = gifts.map(createGiftCard);
        giftBox.replaceChildren(...giftCards);

        nextBtn.disabled = currentPage >= totalPages;
        prevBtn.disabled = currentPage <= 1;
    }
    catch(err){
        console.log(err);
        giftBox.innerHTML='<p>Nu am putut incarca cadourile!</p>';
    }

}

renderGiftPage(currentPage);

document.getElementById("btn__prev").addEventListener('click', () => {
    renderGiftPage(currentPage-1);
});

document.getElementById("btn__next").addEventListener('click', () =>{
    renderGiftPage(currentPage+1);
});