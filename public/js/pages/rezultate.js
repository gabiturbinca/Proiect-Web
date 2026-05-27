const params = new URLSearchParams(window.location.search);
const categoryId = params.get('category_id');
const perPage = 10;
let currentPage=1;

async function getGifts(page){
    let CATEGORIES_GIFTS_URL=`/api/gifts/category/${categoryId}?pageNumber=${page}&elemNumber=${perPage}`;
    const response = await apiFetch(CATEGORIES_GIFTS_URL);
    if(!response.ok){
          const recUrl = new URL("/api/gifts/recommend", window.location.origin);
        const form = new URLSearchParams(window.location.search);

        if(form.get("min"))  recUrl.searchParams.set("budget_min", form.get("min"));
        if(form.get("max"))  recUrl.searchParams.set("budget_max", form.get("max"));

        const categories = form.getAll("categories[]");
        if(categories.length) recUrl.searchParams.set("categories", categories.join(","));

        const brands = form.getAll("brands[]");
        if(brands.length) recUrl.searchParams.set("brands", brands.join(","));

        const tags = form.getAll("tags[]");
        if(tags.length) recUrl.searchParams.set("tags", tags.join(","));

        recUrl.searchParams.set("page", page);
        recUrl.searchParams.set("limit", perPage);

        const response1 = await apiFetch(recUrl.pathname + recUrl.search);
        if(!response1.ok){
            throw new Error("Couldn't fetch the gifts!");
        }

        const rez = await response1.json();
        return rez.success;
    }
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
    card.querySelector('.card__price__gift').textContent="Price : "+ gift.price;

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
        if(gifts_count==0){
            giftBox.innerHTML='<p class="result__message">We could not find any gifts for your requirements. Please try other combinations!</p>';
            nextBtn.style.display="none";
            prevBtn.style.display="none";
            return;
        }
            
        currentPage = page;
        const giftCards = gifts.map(createGiftCard);
        giftBox.replaceChildren(...giftCards);

        nextBtn.disabled = currentPage >= totalPages;
        prevBtn.disabled = currentPage <= 1;
    }
    catch(err){
        console.error(err);
        giftBox.innerHTML='<p class="result__message">We could not load the gifts!</p>';
    }

}

renderGiftPage(currentPage);

document.getElementById("btn__prev").addEventListener('click', () => {
    renderGiftPage(currentPage-1);
});

document.getElementById("btn__next").addEventListener('click', () =>{
    renderGiftPage(currentPage+1);
});