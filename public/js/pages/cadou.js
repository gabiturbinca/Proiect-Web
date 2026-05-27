const params = new URLSearchParams(window.location.search);
const giftId = params.get('gift_id');
const prevBtn = document.getElementById("btn__prev");
const nextBtn = document.getElementById("btn__next");

const prevBtnComm = document.getElementById("btn__prev_comm");
const nextBtnComm = document.getElementById("btn__next_comm");

const reviewForm = document.getElementById("review__form");
const cancelEditBtn = document.getElementById("btn__cancel__edit");
const submitReviewBtn = document.getElementById("btn__submit__review");
const reviewFormHeading = document.getElementById("review_form__heading");
const reviewMessage = document.getElementById("message__review");
const currentUsername = reviewForm ? reviewForm.dataset.username : null;

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
    return rez.success;

}

async function addComment(id, data) {
    const res = await apiFetch(`/api/gifts/${id}/reviews`, {
        method:"POST",
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    });
    const rez = await res.json();
    return { ok: res.ok, body: rez };
}

async function updateComment(id, data) {
    const res = await apiFetch(`/api/reviews/${id}`, {
        method:"PUT",
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    });
    const rez = await res.json();
    return { ok: res.ok, body: rez };
}

async function deleteComment(id) {
    const res = await apiFetch(`/api/reviews/${id}`, {
        method:"DELETE",
    });
    const rez = await res.json();
    return { ok: res.ok, body: rez };
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

    const sendBtn = card.querySelector('#send__gift');
    if (sendBtn) {
        sendBtn.addEventListener('click', () => {
            window.location.href = `/comanda.php?gift_id=${giftId}`;
        });
    }

    return card;
}


function buildRelatedGiftsCard(gift){
    const template = document.getElementById("result__gift");
    const card = template.content.firstElementChild.cloneNode(true);
    card.querySelector('.card__title').textContent = gift.name;
    card.href=`/cadou.php?gift_id=${gift.id}`;
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
    card.dataset.reviewId = review.id;
    card.querySelector('.reviewer_name').textContent=review.username;
    card.querySelector('.comment').textContent=review.comment;

    const rating = Math.round(review.rating * 2);
    const idRating = "rating" + rating;
    const inputs = card.querySelectorAll('.rate input');
    inputs.forEach(input => {
        input.name = "rating_" + review.id;

        const oldIdInput = input.id;
        const newId = oldIdInput + "_" + review.id;
        input.id = newId;
        const associatedFor = card.querySelector(`label[for="${oldIdInput}"]`);
        if(associatedFor)
            associatedFor.setAttribute("for", newId);

        if(oldIdInput == idRating)
            input.checked = true;
    });

    if (currentUsername && review.username === currentUsername) {
        const actions = card.querySelector('.review__actions');
        actions.hidden = false;
        actions.querySelector('.review__edit').addEventListener('click', () => {
            enterEditMode(review);
        });
        actions.querySelector('.review__delete').addEventListener('click', () => {
            handleDelete(review.id);
        });
    }

    return card;
}

function showReviewMessage(text, kind) {
    if (!reviewMessage) return;
    reviewMessage.textContent = text;
    reviewMessage.classList.remove('error__message', 'success__messsage');
    if (kind === 'success') reviewMessage.classList.add('success__messsage');
    if (kind === 'error') reviewMessage.classList.add('error__message');
}

function clearReviewForm() {
    if (!reviewForm) return;
    reviewForm.reset();
    delete reviewForm.dataset.editId;
    submitReviewBtn.textContent = 'Send review';
    reviewFormHeading.textContent = 'Leave a review:';
    cancelEditBtn.hidden = true;
    showReviewMessage('', null);
}

function enterEditMode(review) {
    if (!reviewForm) return;
    reviewForm.dataset.editId = String(review.id);
    submitReviewBtn.textContent = 'Save modifications';
    reviewFormHeading.textContent = 'Modify review:';
    cancelEditBtn.hidden = false;

    reviewForm.querySelector('#comment').value = review.comment ?? '';
    const ratingValue = Math.round(review.rating * 2);
    const input = reviewForm.querySelector(`#rating${ratingValue}`);
    if (input) input.checked = true;

    showReviewMessage('', null);
    reviewForm.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

async function handleDelete(reviewId) {
    if (!confirm('Are you sure you want to delete you review?')) return;
    try {
        const { ok } = await deleteComment(reviewId);
        if (!ok) {
            showReviewMessage('We could not delete the review.', 'error');
            return;
        }
        if (reviewForm && reviewForm.dataset.editId === String(reviewId)) {
            clearReviewForm();
        }
        showReviewMessage('Review deleted.', 'success');
        await renderComments(currentPageReviews);
    } catch {
        showReviewMessage('We could not delete the review.', 'error');
    }
}

async function renderComments(page){
    const container = document.querySelector(".reviews_container");
    try{
        const {reviews, reviews_count} = await getReviews(giftId,page);
        const totalPages = Math.max(1, Math.ceil(reviews_count/elemNumber));
        if(page < 1) return;
        if(reviews_count==0){
            container.innerHTML='<p class="result__message">No reviews yet. Be the first to share your thoughts!</p>';
            prevBtnComm.style.display="none";
            nextBtnComm.style.display="none";
            return;
        }
        prevBtnComm.disabled = page <= 1;
        nextBtnComm.disabled = page >= totalPages;
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
        if(gifts_count==0){
            container.innerHTML='<p class="result__message">We could not find any related gifts. Explore our other categories!</p>';
            prevBtn.style.display="none";
            nextBtn.style.display="none";
            return;
        }
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
        container.innerHTML = '<p>Gift does not exist.</p>';
        return;
    }
    try {
        const gift = await getGift(giftId);
        container.replaceChildren(buildGiftCard(gift));
    } catch (err) {
        console.error(err);
        container.innerHTML = '<p>We could not load the gifts!</p>';
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

if (reviewForm) {
    reviewForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(reviewForm);
        const ratingRaw = formData.get('rating');
        const comment = (formData.get('comment') ?? '').toString().trim();

        if (ratingRaw === null) {
            showReviewMessage('Choose a rating before sending.', 'error');
            return;
        }
        if (comment === '') {
            showReviewMessage('Leave us a comment.', 'error');
            return;
        }

        const payload = {
            rating: Number(ratingRaw) / 2,
            comment,
        };

        const editId = reviewForm.dataset.editId;
        try {
            const { ok, body } = editId
                ? await updateComment(editId, payload)
                : await addComment(giftId, payload);

            if (!ok) {
                const errMsg = body?.error?.review?.[0]
                    || body?.error?.rating?.[0]
                    || body?.error?.comment?.[0]
                    || (typeof body?.error === 'string' ? body.error : null)
                    || 'We could not send the review.';
                showReviewMessage(errMsg, 'error');
                return;
            }

            showReviewMessage(editId ? 'Review updated' : 'Review added.', 'success');
            clearReviewForm();
            await renderComments(currentPageReviews);
        } catch {
            showReviewMessage('Could not send the review.', 'error');
        }
    });

    cancelEditBtn.addEventListener('click', () => {
        clearReviewForm();
    });
}