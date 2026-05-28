const usersBtn = document.getElementById("users");
const giftsBtn = document.getElementById("gifts");
const prevBtn  = document.getElementById("btn__prev");
const nextBtn  = document.getElementById("btn__next");
const ordersBtn = document.getElementById("orders");
const addGiftBtn=document.getElementById("addGift");
const resetPasswordBtn = document.getElementById("resetPassword");
const reportBtn=document.getElementById("report");
const paginationBox = document.getElementById("buttons");

const elemNumber = 10;
let pageNumber = 1;
let totalPages = 1;

let onGifts = false;
let onOrders=false;
let onRequests=false;

function syncHeaderHeight(){
    const header = document.querySelector(".site-header");
    if(!header) return;
    document.documentElement.style.setProperty("--header-height", `${header.offsetHeight}px`);
}
syncHeaderHeight();
window.addEventListener("resize", syncHeaderHeight);

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

async function getFormData(){
    const res = await apiFetch("/api/forms");
    if(!res.ok) throw new Error("Couldn't fetch form data");
    const data = await res.json();
    return data.success;
}

async function getContexts(){
    const URL = "/api/admin/contexts";
    const res = await apiFetch(URL);
    const data = await res.json();
    return data.success;
}
async function getCircumstances(){
    const URL = "/api/admin/circumstances";
    const res = await apiFetch(URL);
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

async function getGift(id){
    const res = await apiFetch(`/api/gifts/${id}`);
    if(!res.ok) throw new Error("Couldn't fetch the gift");
    const data = await res.json();
    return data.success;
}

async function updateGift(id, data){
    const res = await apiFetch(`/api/admin/gifts/${id}`, {
        method:"PATCH",
        headers: {"Content-Type" : "application/json"},
        body: JSON.stringify(data)
    });
    const body = await res.json();
    return { ok: res.ok, body };
}

async function changeUserPassword(userId){
    const URL=`/api/admin/users/${userId}/password-reset`;
    const res = await apiFetch(URL, {
        method:"POST",
        headers:{"Content-Type":"application/json"},
    });
    const result = await res.json();
    return result;
}

async function getPasswordRequests(page){
    const URL = `/api/admin/password-reset-requests?elemNumber=${elemNumber}&pageNumber=${page}`;
    const res = await apiFetch(URL);
    if(!res.ok)
        throw new Error("Couldn't fetch the requests!");
    const result = await res.json();
    return result.success;
}

async function acceptRequest(requestId){
    const URL = `/api/admin/password-reset-requests/${requestId}/approve`;
    const res = await apiFetch(URL, {
        method:"POST",
        headers:{"Content-Type":"application/json"}
    });
    const result = await res.json();
    return result;
}

async function denyRequest(requestId){
    const URL = `/api/admin/password-reset-requests/${requestId}/deny`;
    const res = await apiFetch(URL, {
        method:"POST",
        headers:{"Content-Type":"application/json"}
    });
    const result = await res.json();
    return result;
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
    const circumstances=Array.from(form.querySelectorAll("#form__options__circumstance .checkbox__input:checked"))
    .map(input => parseInt(input.value, 10));
     const contexts=Array.from(form.querySelectorAll("#form__options__context .checkbox__input:checked"))
    .map(input => parseInt(input.value, 10));
    return {
        name,
        description: description || null,
        price,
        category_id,
        brand_id,
        specifications: null,
        tags,
        circumstances,
        contexts,
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

function createCircumstanceCheckbox(template, circumstance){
    const article = template.content.firstElementChild.cloneNode(true);
    article.dataset.circumstanceId = circumstance.id;
    const input = article.querySelector(".checkbox__input");
    input.value = circumstance.id;
    input.name = "circumstances[]";
    input.id = `circumstance-${circumstance.id}`;
    const label = article.querySelector(".checkbox__label");
    label.htmlFor = `circumstance-${circumstance.id}`;
    label.textContent = circumstance.name;
    return article;
}

function createContextCheckbox(template, context){
    const article = template.content.firstElementChild.cloneNode(true);
    article.dataset.contextId = context.id;
    const input = article.querySelector(".checkbox__input");
    input.value = context.id;
    input.name = "contexts[]";
    input.id = `context-${context.id}`;
    const label = article.querySelector(".checkbox__label");
    label.htmlFor = `context-${context.id}`;
    label.textContent = context.name;
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
    const button = row.querySelector(".change-password");
    if(button)
        button.dataset.userId=user.id;

    const badge = row.querySelector(".role-badge");
    badge.textContent = user.user_role;
    badge.classList.add(`role-badge--${user.user_role}`);

    return row;
}

function createRequestRow(request){
    const template = document.getElementById("user__requests_row");
    const row = template.content.firstElementChild.cloneNode(true);

    row.querySelector(".cell__id").textContent=request.id;
    row.querySelector(".cell__identifier").textContent=request.username;
    row.querySelector(".cell__message").textContent=request.message;
    row.querySelector(".cell__status").textContent=request.status;
    const acceptBtn = row.querySelector(".accept");
    const denyBtn = row.querySelector(".deny");
    if(acceptBtn)
        acceptBtn.dataset.requestId=request.id;
    if(denyBtn)
        denyBtn.dataset.requestId=request.id;

    return row;
}

function createGiftRow(gift){
    const template = document.getElementById("gift__row");
    const row = template.content.firstElementChild.cloneNode(true);

    row.querySelector(".cell__name").textContent = gift.name;
    row.querySelector(".cell__description").textContent = gift.description;
    row.querySelector(".cell__price").textContent = gift.price;
    if(gift.score===0)
        row.querySelector(".cell__score").textContent = "No reviews yet";
    else
        row.querySelector(".cell__score").textContent = gift.score;
    const changeBtn = row.querySelector(".gift__change-btn");
    if (changeBtn) {
        changeBtn.dataset.giftId = gift.id;
    }
    const imageInput = row.querySelector(".gift__image-input");
    if (imageInput) {
        imageInput.dataset.giftId = gift.id;
    }
    return row;
}

async function uploadGiftImage(giftId, file){
    const fd = new FormData();
    fd.append("image", file);
    const res = await apiFetch(`/api/admin/gifts/${giftId}/image`, {
        method: "POST",
        body: fd,
    });
    const body = await res.json().catch(() => ({}));
    return { ok: res.ok, body };
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

function buildRequestsTable(requests){
    const template = document.getElementById("users__requests__container");
    const table = template.content.firstElementChild.cloneNode(true);
    const tbody = table.querySelector("tbody");
    tbody.append(...requests.map(createRequestRow));
    return table;
}

async function renderReportForm(){
    const dataBox = document.getElementById("admin__data_container");
    try{
        hidePagination();
        const { categories } = await getFormData();

        const formTpl = document.getElementById("report_form__container");
        const form = formTpl.content.firstElementChild.cloneNode(true);

        const categorySelect = form.querySelector(".report__category-select");
        categories.forEach(cat => {
            const opt = document.createElement("option");
            opt.value = cat.id;
            opt.textContent = cat.name;
            categorySelect.append(opt);
        });

        const typeSelect = form.querySelector(".report__type-select");
        const categoryField = form.querySelector("#report__category-field");
        const syncCategoryVisibility = () => {
            if(typeSelect.value === "orders"){
                categoryField.classList.remove("invisible");
            } else {
                categoryField.classList.add("invisible");
                categorySelect.value = "";
            }
        };
        typeSelect.addEventListener("change", syncCategoryVisibility);
        syncCategoryVisibility();

        dataBox.replaceChildren(form);

        form.addEventListener("submit", (e) => {
            e.preventDefault();
            const params = new URLSearchParams();
            params.set("type", typeSelect.value);
            params.set("format", form.querySelector(".report__format-select").value);
            const from = form.querySelector("#report_from").value;
            const to = form.querySelector("#report_to").value;
            if(from) params.set("from", from);
            if(to) params.set("to", to);
            if(typeSelect.value === "orders" && categorySelect.value){
                params.set("category", categorySelect.value);
            }
            window.open(`/api/admin/reports?${params.toString()}`, "_blank");
        });
    }
    catch(err){
        console.error(err);
        dataBox.innerHTML = "<p>Couldn't load the report form!</p>";
    }
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

async function renderGiftForm(gift = null){
    const dataBox = document.getElementById("admin__data_container");
    try{
        hidePagination();
        const { categories, brands, tags } = await getFormData();
        const contexts = await getContexts();
        const circumstances = await getCircumstances();
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

        const contextTpl=form.querySelector("#context_template");
        const contextBox = form.querySelector("#form__options__context");
        contexts.forEach(context => contextBox.append(createContextCheckbox(contextTpl, context)));

        const circumstanceTpl=form.querySelector("#circumstance_template");
        const circumstanceBox = form.querySelector("#form__options__circumstance");
        circumstances.forEach(circumstance => circumstanceBox.append(createCircumstanceCheckbox(circumstanceTpl, circumstance)));

        if(gift){
            form.querySelector("#name").value = gift.name ?? "";
            form.querySelector("#description").value = gift.description ?? "";
            form.querySelector("#price").value = gift.price ?? "";

            const categoryId = categories.find(c => c.name === gift.category_name)?.id ?? "";
            const brandId    = brands.find(b => b.name === gift.brand_name)?.id ?? "";
            catSelect.value   = categoryId;
            brandSelect.value = brandId;

            const tagIds = new Set((gift.tags ?? []).map(t => t.id));
            form.querySelectorAll("#form__options__tag .checkbox__input").forEach(cb => {
                cb.checked = tagIds.has(parseInt(cb.value, 10));
            });

            const contextIds = new Set((gift.contexts ?? []).map(c => parseInt(c, 10)));
            form.querySelectorAll("#form__options__context .checkbox__input").forEach(cb => {
                cb.checked = contextIds.has(parseInt(cb.value, 10));
            });

            const circumstanceIds = new Set((gift.circumstances ?? []).map(c => parseInt(c, 10)));
            form.querySelectorAll("#form__options__circumstance .checkbox__input").forEach(cb => {
                cb.checked = circumstanceIds.has(parseInt(cb.value, 10));
            });

            const submitBtn = form.querySelector(".btn-add-gift");
            if(submitBtn) submitBtn.textContent = "Save changes";
        }

        dataBox.replaceChildren(form);

        form.addEventListener("submit", async(e) =>{
            e.preventDefault();
            const data = collectGiftFormData(form);
            const { ok, body } = gift
                ? await updateGift(gift.id, data)
                : await addGift(data);
            if(!ok){
                alert(body?.error ?? (gift ? "Couldn't update the gift." : "Couldn't add the gift."));
                return;
            }
            if(gift){
                alert("Gift updated!");
                await renderGifts();
            } else {
                form.reset();
                alert("Gift added!");
            }
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
        if(gifts_count==0){
            dataBox.innerHTML='<p class="result__message">There are no gifts yet. Add one to get started!</p>';
            hidePagination();
            return;
        }
        dataBox.replaceChildren(buildGiftsTable(gifts));
        updatePaginationUI();

        const changeGiftBtns = document.querySelectorAll(".gift__change-btn");
        changeGiftBtns.forEach((changeGiftBtn) => {
            changeGiftBtn.addEventListener("click", async(e) =>{
                const giftId = changeGiftBtn.dataset.giftId;
                try {
                    const gift = await getGift(giftId);
                    await renderGiftForm(gift);
                } catch(err){
                    console.error(err);
                    alert("Couldn't load the gift to edit.");
                }
            });
        });

        const imageInputs = document.querySelectorAll(".gift__image-input");
        imageInputs.forEach((imageInput) => {
            imageInput.addEventListener("change", async() => {
                if(!imageInput.files.length) return;
                const giftId = imageInput.dataset.giftId;
                const { ok, body } = await uploadGiftImage(giftId, imageInput.files[0]);
                imageInput.value = "";
                if(!ok){
                    alert(body?.error ?? "Couldn't upload the image.");
                    return;
                }
                alert("Image uploaded!");
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
        if(orders_count==0){
            dataBox.innerHTML='<p class="result__message">There are no orders yet.</p>';
            hidePagination();
            return;
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
async function renderPasswordRequests(){
    const dataBox = document.getElementById("admin__data_container");
    try{
        const {requests, requests_count} = await getPasswordRequests(pageNumber);
        totalPages = Math.max(1, Math.ceil(requests_count / elemNumber));
        if (pageNumber > totalPages) {
            pageNumber = totalPages;
        }
        if(requests_count==0){
            dataBox.innerHTML='<p class="result__message">There are no password reset requests.</p>';
            hidePagination();
            return;
        }
        dataBox.replaceChildren(buildRequestsTable(requests));
        updatePaginationUI();
        const acceptButtons=document.querySelectorAll(".accept");
        const denyButtons=document.querySelectorAll(".deny");
        acceptButtons.forEach(acceptButton => {
            acceptButton.addEventListener("click", async(e) =>{
                e.preventDefault();
                if(!confirm("Are you sure you want to accept their request?")) return;
                const res= await acceptRequest(acceptButton.dataset.requestId);
                if(res.success){
                    alert(`Request accepted with the temporary password ${res.success.tempPassword}`);
                }
                if(res.error){
                    alert("Request couldn't be accepted!");
                }
                await renderPasswordRequests();
            });
        });

        denyButtons.forEach(denyButton => {
            denyButton.addEventListener("click", async(e) => {
                e.preventDefault();
                if(!confirm("Are you sure you want to deny their request?")) return;
                const res= await denyRequest(denyButton.dataset.requestId);
                if(res.success){
                    alert("Request denied!");
                }
                if(res.error){
                    alert("Request couldn't be denied!");
                }
                await renderPasswordRequests();
            });
        });
    }
    catch(err){
        console.error(err);
        dataBox.innerHTML = "<p>Couldn't fetch the requests. Try again next time!</p>";
    }
}

async function onClickUsers(){
    hidePagination();
    onGifts=false; onOrders=false; onRequests=false;
    const dataBox = document.getElementById("admin__data_container");
    try{
        const users = await getAllUsers();
        dataBox.replaceChildren(buildUsersTable(users));
        const changePasswordBtns = document.querySelectorAll(".change-password");
        changePasswordBtns.forEach(changePasswordBtn => {
            changePasswordBtn.addEventListener("click", async(e) =>{
                e.preventDefault();
                if(!confirm("Are you sure you want to change the password of this user?")) return;
                const res = await changeUserPassword(changePasswordBtn.dataset.userId);
                if(res.success){
                    alert(`Success. Their temporary password is ${res.success.tempPassword}`);
                }
                if(res.error){
                    alert("Error changing their password. Try again");
                }
            });
        });
    }
    catch(err){
        console.error(err);
        dataBox.innerHTML = "<p>Couldn't fetch the users. Try again next time!</p>";
    }
}

onClickUsers();

usersBtn.addEventListener("click", async (e) => {
    e.preventDefault();
    onClickUsers();
});

giftsBtn.addEventListener("click", async (e) => {
    e.preventDefault();
    onGifts=true; onOrders=false; onRequests=false;
    pageNumber = 1;
    showPagination();
    await renderGifts();
});


ordersBtn.addEventListener("click", async(e) =>{
    e.preventDefault();
    onGifts = false; onOrders=true;  onRequests=false;
    pageNumber=1;
    showPagination();
    await renderOrders();
});

addGiftBtn.addEventListener("click", async(e) => {
    e.preventDefault();
    onGifts=false; onOrders=true;  onRequests=false;
    hidePagination();
    await renderGiftForm();
});

reportBtn.addEventListener("click", async(e) => {
    e.preventDefault();
    onGifts=false; onOrders=false;  onRequests=false;
    hidePagination();
    await renderReportForm();
});

resetPasswordBtn.addEventListener("click", async(e) =>{
    e.preventDefault();
    onGifts = false; onOrders=false;  onRequests=true;
    pageNumber=1;
    showPagination();
    await renderPasswordRequests();
});

prevBtn.addEventListener("click", async (e) => {
    e.preventDefault();
    if (pageNumber > 1) {
        pageNumber--;
        if(onGifts)
            await renderGifts();
        else if(onOrders)
            await renderOrders();
        else if(onRequests)
            await renderPasswordRequests();
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
        else if(onRequests)
            await renderPasswordRequests();
    }
});
