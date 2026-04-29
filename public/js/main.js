const toggle = document.querySelector('.navbar__toggle');
const menu   = document.getElementById('primary-menu');

toggle?.addEventListener('click', () => {
  const isOpen = menu.classList.toggle('is-open');
  toggle.setAttribute('aria-expanded', String(isOpen));
  toggle.setAttribute('aria-label', isOpen ? 'Închide meniul' : 'Deschide meniul');
});


const CATEGORIES_URL="/mock/categories.json";

async function getCategories() {
  const response = await fetch(CATEGORIES_URL);
  if (!response.ok) {
    throw new Error(`Failed to load categories: ${response.status}`);
  }
  const data = await response.json();
  return data.categories;
  
}

function createCategoryCard(category)
{
  const template=document.getElementById("category-card-template");
  const card = template.content.firstElementChild.cloneNode(true);

  card.href = `/recomandare.php?category_id=${category.id}`;
  card.querySelector('.card__image').src=category.image_url;
  card.querySelector('.card__image').alt=category.name;
  card.querySelector('.card__title').textContent=category.name;
  card.querySelector('.card__desc').textContent=category.description;

  return card;
}

async function renderCategories(){
  const categoriesBox = document.getElementById("categories_only_cards");
  try{
    const categories = await getCategories();
    const cards = categories.map(createCategoryCard);
    categoriesBox.replaceChildren(...cards);
  }
  catch(error){
    console.error(error);
    categoriesBox.innerHTML='<p>Nu am putut incarca categoriile!</p>';
  }
}

renderCategories();