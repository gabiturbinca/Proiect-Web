const usersBtn = document.getElementById("users");
const giftsBtn = document.getElementById("gifts");
const prevBtn  = document.getElementById("btn__prev");
const nextBtn  = document.getElementById("btn__next");
const deleteBtn = document.getElementById("delete");
const paginationBox = document.getElementById("buttons");

const elemNumber = 10;
let pageNumber = 1;
let totalPages = 1;


async function getAllUsers(){
    const URL = "/api/users";
    const res = await apiFetch(URL);
    if(!res.ok){
        throw new Error("Error fetching this info");
    }
    const data = await res.json();
    return data.success;
    
}


async function getGifts(page){
    const URL = `/api/gifts?elemNumber=${elemNumber}&pageNumber=${page}`;
    const res = await apiFetch(URL);
    if(!res.ok){
        throw new Error("Error fetching this info");
    }
    const data = await res.json();
    return data.success;
}

function createUserRow(user){
    const template = document.getElementById("user__row");
    const row = template.content.firstElementChild.cloneNode(true);

    row.querySelector(".cell__id").textContent = user.id;
    row.querySelector(".cell__username").textContent = user.username;
    row.querySelector(".cell__email").textContent = user.email;

    const badge = row.querySelector(".role-badge");
    badge.textContent = user.user_role;
    badge.classList.add(`role-badge--${user.user_role}`);

    return row;
}

function createGiftRow(gift){
    const template = document.getElementById("gift__row");
    const row = template.content.firstElementChild.cloneNode(true);

    row.querySelector(".cell__name").textContent = gift.name;
    row.querySelector(".cell__description").textContent = gift.description;
    row.querySelector(".cell__price").textContent = gift.price;
    row.querySelector(".cell__score").textContent = gift.score;

    return row;
}

function buildUsersTable(users){
    const template = document.getElementById("users__container");
    const table = template.content.firstElementChild.cloneNode(true);
    const tbody = table.querySelector("tbody");
    tbody.append(...users.map(createUserRow));
    return table;
}

function buildGiftsTable(gifts){
    const template = document.getElementById("gifts__container");
    const table = template.content.firstElementChild.cloneNode(true);
    const tbody = table.querySelector("tbody");
    tbody.append(...gifts.map(createGiftRow));
    return table;
}

function showPagination(){
    paginationBox.classList.remove("invisible");
    paginationBox.classList.add("visible");
}

function hidePagination(){
    paginationBox.classList.remove("visible");
    paginationBox.classList.add("invisible");
}

function updatePaginationUI(){
    prevBtn.disabled = pageNumber <= 1;
    nextBtn.disabled = pageNumber >= totalPages;
}

async function renderGifts(){
    const dataBox = document.getElementById("admin__data_container");
    try{
        const { gifts, gifts_count } = await getGifts(pageNumber);
        totalPages = Math.max(1, Math.ceil(gifts_count / elemNumber));
        if (pageNumber > totalPages) {
            pageNumber = totalPages;
        }
        dataBox.replaceChildren(buildGiftsTable(gifts));
        updatePaginationUI();
    }
    catch(err){
        console.error(err);
        dataBox.innerHTML = "<p>Couldn't fetch the gifts. Try again next time!</p>";
    }
}

usersBtn.addEventListener("click", async (e) => {
    e.preventDefault();
    hidePagination();
    const dataBox = document.getElementById("admin__data_container");
    try{
        const users = await getAllUsers();
        dataBox.replaceChildren(buildUsersTable(users));
    }
    catch(err){
        console.error(err);
        dataBox.innerHTML = "<p>Couldn't fetch the users. Try again next time!</p>";
    }
});

giftsBtn.addEventListener("click", async (e) => {
    e.preventDefault();
    pageNumber = 1;
    showPagination();
    await renderGifts();
});

prevBtn.addEventListener("click", async (e) => {
    e.preventDefault();
    if (pageNumber > 1) {
        pageNumber--;
        await renderGifts();
    }
});

nextBtn.addEventListener("click", async (e) => {
    e.preventDefault();
    if (pageNumber < totalPages) {
        pageNumber++;
        await renderGifts();
    }
});


deleteBtn("click", async(e) => {
    e.preventDefault();

})