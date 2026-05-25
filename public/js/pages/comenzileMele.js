const perPage = 5;
let currentPage = 1;

async function getCommands(page){
    const URL=`/api/orders?pageNumber=${page}&elemNumber=${perPage}`;
    const res = await apiFetch(URL);
    if(!res.ok){
        throw new Error("Couldn't fetch the user orders");
    }
    const data = await res.json();
    console.log(data.success);
    return data.success;
}

async function cancelOrder(orderId){
    const URL = `/api/orders/${orderId}/cancel`;
    const res = await apiFetch(URL, {
        method : "PATCH", 

    });
    const data = await res.json();
    return { ok: res.ok, body: data };

}
function createCommandCard(command_details){
    const template = document.getElementById("commands_template");
    const card = template.content.firstElementChild.cloneNode(true);
    card.querySelector(".card__gift_name").textContent = " " + command_details.gift_name;
    card.querySelector(".card__time").textContent = " " + command_details.created_at;
    card.querySelector(".card__address").textContent = " " + command_details.address;
    card.querySelector(".card__description").textContent = " " + command_details.description;
    card.querySelector(".card__quantity").textContent = " " + command_details.quantity;
    card.querySelector(".card__status").textContent = " " + command_details.status;
    card.dataset.orderId=command_details.id;

    return card;
}

async function renderOrdersPage(page){
    if(page<1) return;
    const commandBox=document.getElementById("commands_cards");
    const nextBtn = document.getElementById("btn__next");
    const prevBtn = document.getElementById("btn__prev");
    try{
       const {orders, orders_count} = await getCommands(page);
       const nrPages = Math.ceil(orders_count/perPage);
       if(page > nrPages) return;
       currentPage = page;
       const orderCards = orders.map(createCommandCard);
       commandBox.replaceChildren(...orderCards);
       prevBtn.disabled = (page === 1);
       nextBtn.disabled = (page === nrPages);

       const cancelBtns = document.querySelectorAll(".btn-cancel-order");
       cancelBtns.forEach(cancelBtn => {
            cancelBtn.addEventListener("click", async(e) => {
                const state = cancelBtn.parentElement.querySelector(".card__status").textContent.trim();
                console.log(state);
                if(state != 'placed'){
                    if(state==='cancelled'){
                        alert("The order is already cancelled!");
                        return;
                    }

                    alert("You can't cancel orders that are already shipped or delivered!");
                    return;
                }
                if(!confirm("Are you sure you want to cancel this order?")) return;
                const orderId = cancelBtn.parentElement.dataset.orderId;
                await cancelOrder(orderId);
                await renderOrdersPage(page);
            });
       });
    }
    catch{
        commandBox.innerHTML='<p>We could not load you orders!</p>';
    }
}

renderOrdersPage(currentPage);

document.getElementById("btn__prev").addEventListener('click', () => {
    renderOrdersPage(currentPage-1);
});

document.getElementById("btn__next").addEventListener('click', () =>{
    renderOrdersPage(currentPage+1);
});