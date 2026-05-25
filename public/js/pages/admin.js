const usersBtn = document.getElementById("users");
const giftsBtn = document.getElementById("gifts");
const prevBtn  = document.getElementById("btn__prev");
const nextBtn  = document.getElementById("btn__next");
const ordersBtn = document.getElementById("orders");
const addGiftBtn=document.getElementById("addGift");
const paginationBox = document.getElementById("buttons");

const elemNumber = 10;
let pageNumber = 1;
let totalPages = 1;

let onGifts = false;
let onOrders=false;


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


async function getOrders(page){
    const URL = `/api/admin/orders?elemNumber=${elemNumber}&pageNumber=${page}`;
    const res = await apiFetch(URL);
    if(!res.ok)
        throw new Error("Couldn't fetch the orders!");
    const data = await res.json();
    console.log(data.success);
    return data.success;
}

async function changeOrderStatus(orderId, status){
    const URL = `/api/admin/orders/${orderId}/status`;
    const res = await apiFetch(URL, {
        method: "PATCH",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ status })
    });
    const data = await res.json();
    return { ok: res.ok, body: data };
}

async function deleteGift(id){
    const URL=`/api/admin/gifts/${id}`;
    const res = await apiFetch(URL, {
        method : "DELETE"
    });
    const data = await res.json();
    return { ok: res.ok, body: data };
}

async function getFormData(){
    const res = await apiFetch("/api/forms");
    if(!res.ok) throw new Error("Couldn't fetch form data");
    const data = await res.json();
    return data.success;
}

async function addGift(data){
    const res = await apiFetch("/api/admin/gifts", {
        method:"POST",
        headers: {"Content-Type" : "application/json"},
        body: JSON.stringify(data)
    });
    const body = await res.json();
    return { ok: res.ok, body };
}

function collectGiftFormData(form){
    const name = form.querySelector("#name").value.trim();
    const description = form.querySelector("#description").value.trim();
    const price = parseFloat(form.querySelector("#price").value);
    const category_id = parseInt(form.querySelector(".gift__category-select").value, 10);
    const brandValue = form.querySelector(".gift__brand-select").value;
    const brand_id = brandValue ? parseInt(brandValue, 10) : null;
    const tags = Array.from(form.querySelectorAll("#form__options__tag .checkbox__input:checked")
    ).map(input => parseInt(input.value, 10));

    return {
        name,
        description: description || null,
        price,
        category_id,
        brand_id,
        specifications: null,
        tags,
        circumstances: [],
        contexts: [],
    };
}

function createTagCheckbox(template, tag){
    const article = template.content.firstElementChild.cloneNode(true);
    article.dataset.tagId = tag.id;
    const input = article.querySelector(".checkbox__input");
    input.value = tag.id;
    input.name = "tags[]";
    input.id = `tag-${tag.id}`;
    const label = article.querySelector(".checkbox__label");
    label.htmlFor = `tag-${tag.id}`;
    label.textContent = tag.name;
    return article;
}

function createCategoryOption(category){
    const option = document.createElement("option");
    option.value = category.id;
    option.dataset.categoryId = category.id;
    option.textContent = category.name;
    return option;
}

function createCategorySelect(categories){
    const template = document.getElementById("category_template");
    const select = template.content.firstElementChild.cloneNode(true);
    select.append(...categories.map(createCategoryOption));
    return select;
}

function createBrandOption(brand){
    const option = document.createElement("option");
    option.value = brand.id;
    option.dataset.brandId = brand.id;
    option.textContent = brand.name;
    return option;
}

function createBrandSelect(brands){
    const template = document.getElementById("brand_template");
    const select = template.content.firstElementChild.cloneNode(true);
    select.append(...brands.map(createBrandOption));
    return select;
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
    const deleteBtn = row.querySelector(".gift__delete-btn");
    if (deleteBtn) {
        deleteBtn.dataset.giftId = gift.id;
    }
    return row;
}

function createOrderRow(order){
    const template = document.getElementById("order__row");
    const row = template.content.firstElementChild.cloneNode(true);

    row.querySelector(".cell__gift_name").textContent=order.gift_name;
    row.querySelector(".cell__recipient").textContent=order.recipient_name;
    row.querySelector(".cell_user").textContent=order.username;
    row.querySelector(".cell__address").textContent=order.address;
    row.querySelector(".cell__quantity").textContent=order.quantity;
    row.querySelector(".cell__status").textContent=order.status;
    const select = row.querySelector(".order__status-select");
    if(select){
        select.value = order.status;
        select.dataset.orderId=order.id;
    }
    const changeBtn = row.querySelector(".order__change-status-btn");
    if(changeBtn)
    {
        changeBtn.dataset.orderId=order.id;
    }
    return row;

}

function buildOrdersTable(orders){
    const template = document.getElementById("orders__container");
    const table = template.content.firstElementChild.cloneNode(true);
    const tbody = table.querySelector("tbody");
    tbody.append(...orders.map(createOrderRow));
    return table;
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

async function renderGiftForm(){
    const dataBox = document.getElementById("admin__data_container");
    try{
        hidePagination();
        const { categories, brands, tags } = await getFormData();

        const formTpl = document.getElementById("add_gift__container");
        const form = formTpl.content.firstElementChild.cloneNode(true);

        const catSelect = form.querySelector("#category_template").content.firstElementChild.cloneNode(true);
        catSelect.name = "category_id";
        catSelect.append(...categories.map(createCategoryOption));
        form.querySelector("#form__options__category").append(catSelect);

        const brandSelect = form.querySelector("#brand_template").content.firstElementChild.cloneNode(true);
        brandSelect.name = "brand_id";
        brandSelect.append(...brands.map(createBrandOption));
        form.querySelector("#form__options__brand").append(brandSelect);

        const tagTpl = form.querySelector("#tag_template");
        const tagBox = form.querySelector("#form__options__tag");
        tags.forEach(tag => tagBox.append(createTagCheckbox(tagTpl, tag)));

        dataBox.replaceChildren(form);

        form.addEventListener("submit", async(e) =>{
            e.preventDefault();
            const data = collectGiftFormData(form);
            const { ok, body } = await addGift(data);
            if(!ok){
                alert(body?.error ?? "Couldn't add the gift.");
                return;
            }
            form.reset();
            alert("Gift added!");
        });
    }
    catch(err){
        dataBox.innerHTML="<p>Couldn't render the form!</p>";
    }
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

        const deleteGiftBtns = document.querySelectorAll(".gift__delete-btn");
        deleteGiftBtns.forEach((deleteGiftBtn) => {
        deleteGiftBtn.addEventListener("click", async(e) =>{
            if(!confirm("Are you sure you want to delete this gift?")) return;
            const giftId = deleteGiftBtn.dataset.giftId;
            await deleteGift(giftId);
            showPagination();
            await renderGifts();
        });
});
    }
    catch(err){
        console.error(err);
        dataBox.innerHTML = "<p>Couldn't fetch the gifts. Try again next time!</p>";
    }
}

async function renderOrders(page){
    const dataBox = document.getElementById("admin__data_container");
    try{
        const { orders, orders_count } = await getOrders(pageNumber);
        totalPages = Math.max(1, Math.ceil(orders_count / elemNumber));
        if (pageNumber > totalPages) {
            pageNumber = totalPages;
        }
        dataBox.replaceChildren(buildOrdersTable(orders));
        updatePaginationUI();
        const changeStatusBtns = document.querySelectorAll(".order__change-status-btn");

        changeStatusBtns.forEach(changeBtn =>{
            changeBtn.addEventListener("click", async(e) => {
                const orderId = changeBtn.dataset.orderId;
                const row = changeBtn.closest("tr");
                const select = changeBtn.closest("tr").querySelector(".order__status-select");
                const status = select.value;
                const oldStatus= row.querySelector(".cell__status").textContent;
                const { ok } = await changeOrderStatus(orderId, status);
                if(!ok){
                    alert(`Couldn't update the order status to ${status}.`);
                    select.value = oldStatus;
                    return;
                }
                await renderOrders();
            });
        });
        
    }
    catch(err){
        console.error(err);
        dataBox.innerHTML = "<p>Couldn't fetch the orders. Try again next time!</p>";
    }
}
usersBtn.addEventListener("click", async (e) => {
    e.preventDefault();
    hidePagination();
    onGifts=false; onOrders=false;
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
    onGifts=true; onOrders=false;
    pageNumber = 1;
    showPagination();
    await renderGifts();
});


ordersBtn.addEventListener("click", async(e) =>{
    e.preventDefault();
    onGifts = false; onOrders=true;
    pageNumber=1;
    showPagination();
    await renderOrders();
});

addGiftBtn.addEventListener("click", async(e) => {
    e.preventDefault();
    onGifts=false; onOrders=true;
    hidePagination();
    await renderGiftForm();
});

prevBtn.addEventListener("click", async (e) => {
    e.preventDefault();
    if (pageNumber > 1) {
        pageNumber--;
        if(onGifts)
            await renderGifts();
        else if(onOrders)
            await renderOrders();
    }
});

nextBtn.addEventListener("click", async (e) => {
    e.preventDefault();
    if (pageNumber < totalPages) {
        pageNumber++;
        if(onGifts)
            await renderGifts();
        else if(onOrders)
            await renderOrders();
    }
});

