const toggle = document.querySelector('.navbar__toggle');
const menu   = document.getElementById('primary-menu');

toggle?.addEventListener('click', () => {
  const isOpen = menu.classList.toggle('is-open');
  toggle.setAttribute('aria-expanded', String(isOpen));
  toggle.setAttribute('aria-label', isOpen ? 'Închide meniul' : 'Deschide meniul');
});


const CATEGORIES_URL="/api/categories-short";
const FILTERS_URL="/api/forms";

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


async function getFilters(){
      const response = await fetch(FILTERS_URL);
      if(!response.ok)
          throw new Error(`Couldn't find the filters ${response.status}`);

      const data = await response.json();
      return data.success;
}

function createCategoryLabel(category)
{
    const template=document.getElementById("category_template");
    const card = template.content.firstElementChild.cloneNode(true);

    const input = card.querySelector(".checkbox__input");
    const label = card.querySelector(".checkbox__label");

    const inputId=`cat-${category.id}`;
    input.id=inputId;
    input.name='categories[]';
    input.value=category.id;

    label.htmlFor=inputId;
    label.textContent=category.name;

    return card;
}

function createBrandLabel(brand)
{
    const template=document.getElementById("brand_template");
    const card = template.content.firstElementChild.cloneNode(true);

    const input = card.querySelector(".checkbox__input");
    const label = card.querySelector(".checkbox__label");

    const inputId=`brand-${brand.id}`;
    input.id=inputId;
    input.name='brands[]';
    input.value=brand.id;

    label.htmlFor=inputId;
    label.textContent=brand.name;

    return card;
}

function createTagLabel(tag)
{
    const template=document.getElementById("tag_template");
    const card = template.content.firstElementChild.cloneNode(true);

    const input = card.querySelector(".checkbox__input");
    const label = card.querySelector(".checkbox__label");

    const inputId=`tag-${tag.id}`;
    input.id=inputId;
    input.name='tags[]';
    input.value=tag.id;

    label.htmlFor=inputId;
    label.textContent=tag.name;

    return card;
}


async function renderFilters(){
  const categoryBox=document.getElementById("quiz__options__category");
  const brandBox=document.getElementById("quiz__options__brand");
  const tagBox=document.getElementById("quiz__options__tag");
  try{
    const {categories,brands,tags} = await getFilters();
    const categoryCards = categories.map(createCategoryLabel);
    const brandCards = brands.map(createBrandLabel);
    const tagCards = tags.map(createTagLabel);
    categoryBox.replaceChildren(...categoryCards);
    brandBox.replaceChildren(...brandCards);
    tagBox.replaceChildren(...tagCards);
  }
  catch(error){
    console.error(error);
    categoryBox.innerHTML='<p>Nu am putut incarca categoriile!</p>';
    brandBox.innerHTML='<p>Nu am putut incarca brandurile!</p>';
    tagBox.innerHTML='<p>Nu am putut incarca tagurile!</p>';
  }
}

renderFilters();


