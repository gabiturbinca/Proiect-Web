//get commands per page
//pageNumber -> a cata pagina
//elemNumber -> cate per pagina
const perPage = 5;
let currentPage = 1;

async function getCommands(page){
    const URL="/data/comenzileMele.json";
    const res = await fetch(URL);
    if(!res.ok){
        throw new Error("Couldn't fetch the user commands");
    }
    const data = await res.json();
    return data;
}

function createCommandcard(command_details){
    const template = document.getElementById("commands_template");
    const card = template.content.firstElementChild.cloneNode(true);

    card.querySelector(".card__awb").textContent="AWB: " + command_details.awb;
    card.querySelector(".card__time").textContent="Data si ora: " + command_details.datetime;
    card.querySelector(".card__status").textContent=command_details.status;

    return card;
}

async function renderCommandsPage(page){
    if(page<1) return;
    const commandBox=document.getElementById("commands_cards");
    const nextBtn = document.getElementById("btn__next");
    const prevBtn = document.getElementById("btn__prev");
    try{
        const {total, data} = await getCommands(page);
        const totalPages = Math.ceil(total/perPage);
        if (page > totalPages) return;
        currentPage = page;
        const start = (page - 1) * perPage;
        const slice = data.slice(start, start + perPage);
        commandBox.innerHTML = '';
        slice.forEach(c => commandBox.appendChild(createCommandcard(c)));
        prevBtn.disabled = page === 1;
        nextBtn.disabled = page === totalPages;
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