const CATEGORIES_URL="/api/categories-short";

async function getCategories() {
  const response = await fetch(CATEGORIES_URL);
  if (!response.ok) {
    throw new Error(`Failed to load categories: ${response.status}`);
  }
  const data = await response.json();
  return data.success;
  
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
  if (!categoriesBox) return;
  try{
    const categories = await getCategories();
    console.log(categories);
    const cards = categories.map(createCategoryCard);
    categoriesBox.replaceChildren(...cards);
  }
  catch(err){
    console.error(err);
    categoriesBox.innerHTML='<p>Nu am putut incarca categoriile!</p>';
  }
}

renderCategories();