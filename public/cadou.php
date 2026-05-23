<?php
    $page_title = 'Pagina cadou';
    $page_css   = 'cadou';
    $page_js = 'cadou';
    require __DIR__ . '/../templates/header.php';
?>
    
    <template id="gift__card">
        <h1 class="gift__title"></h1>

        <div class="gift__row">
            <div id="gift__header">
                <img class="gift__image" src="" alt="">
            </div>

            <div id="gift__mini__container">
                <div class="gift__details">
                    <p><strong>Descriere: </strong><span class="gift__description"></span></p>
                    <p><strong>Pret: </strong><span class="gift__price"></span></p>
                    <p><strong>Brand: </strong><span class="gift__brand"></span></p>
                    <p><strong>Categorie: </strong><span class="gift__category"></span></p>
                    <div class="gift__specs"></div>
                </div>

                <div class="gift__buttons">
                    <button class="btn btn--primary" id="send__gift">Trimite cadou</button>
                </div>
                <div class="gift__tags"></div>
               
            </div>
        </div>
    </template>

    <template id="gift__spec">
        <p><strong class="gift__spec__label"></strong><span class="gift__spec__value"></span></p>
    </template>

     
    <section class="gift__container" id="gift__container">

    </section>
          
    <section class="related__gifts__container">
        <h2 class="gift__header">Cadouri similare:</h2>
          <div id ="related_gifts" class="related_gifts"></div>
          
          <template id="result__gift" class="result__gift">
                <a href ="" class ="card card__gift" id="gift__link">
                    <img src="" alt="" class ="card__image">
                    <p class="card__title"></p>
                    <p class="card__desc card__description"></p>
                    <p class="card__desc card__brand"></p>
                    <p class="card__desc card__category"></p>
                    <p class="card__desc card__price"></p>
                    <span class="btn btn--primary">Vezi detalii cadou</span>
                </a>
            </template>

            <div class ="buttons__pagination">
                <button type="button" class="btn btn--accent" id="btn__prev">Prev</button>
                <button type="button" class="btn btn--accent" id="btn__next">Next</button>
            </div>
    </section>

<?php
    require __DIR__ . '/../templates/footer.php';
?>
