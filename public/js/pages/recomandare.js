const FILTERS_URL="/api/forms";

async function getFilters(){
      const response = await apiFetch(FILTERS_URL);
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


