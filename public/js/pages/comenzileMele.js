//get commands per page
//pageNumber -> a cata pagina
//elemNumber -> cate per pagina
const perPage = 5;
let currentPage = 1;

async function getCommands(page){
    const URL=`/api/orders?pageNumber=${page}&elemNumber=${perPage}`;
    const res = await fetch(URL);
    if(!res.ok){
        throw new Error("Couldn't fetch the user commands");
    }
    const data = await res.json();
    console.log(data.success);
    return data.success;
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
    return card;
}

async function renderCommandsPage(page){
    if(page<1) return;
    const commandBox=document.getElementById("commands_cards");
    const nextBtn = document.getElementById("btn__next");
    const prevBtn = document.getElementById("btn__prev");
    try{
       const {orders, orders_count} = await getCommands(page);
       console.log(orders);
       if(page < 1) return;
       const nrPages = Math.ceil(orders_count/perPage);
       if(page == nrPages)
            nextBtn.disabled=true;
       if(page==1)
            prevBtn.disabled=true;
        orderCards=orders.map(createCommandCard);
        commandBox.append(...orderCards);
       
    }
    catch{
        commandBox.innerHTML='<p>Nu am putut incarca comenzile dvs!</p>';
    }
}

renderCommandsPage(currentPage);

document.getElementById("btn__prev").addEventListener('click', () => {
    renderCommandsPage(currentPage-1);
});

document.getElementById("btn__next").addEventListener('click', () =>{
    renderCommandsPage(currentPage+1);
});