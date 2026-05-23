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
        <h2 class="gift__header">Similar gifts:</h2>
          <div id ="related_gifts" class="related_gifts"></div>
          
          <template id="result__gift" class="result__gift">
                <a href ="" class ="card card__gift" id="gift__link">
                    <img src="" alt="" class ="card__image">
                    <p class="card__title"></p>
                    <p class="card__desc card__description"></p>
                    <p class="card__desc card__brand"></p>
                    <p class="card__desc card__category"></p>
                    <p class="card__desc card__price"></p>
                    <span class="btn btn--primary">See gift details</span>
                </a>
            </template>

            <div class ="buttons__pagination">
                <button type="button" class="btn btn--accent" id="btn__prev">Prev</button>
                <button type="button" class="btn btn--accent" id="btn__next">Next</button>
            </div>
    </section>


    <section class="reviews">
        <div class="reviews__title">
            <h2 class="gift__header">Reviews:</h2>
        </div>

        <div class="add_review"></div>

        <div class="reviews_container"></div>

        <template id="review">
            <div class="review_card">
                 <svg width="10" height="10">
                    <circle cx="50" cy="50" r="40" stroke="black" stroke-width="3" fill="red" />
                </svg>
                <p class="reviewer_name"></p>


                <fieldset class="rate">
                    <input type="radio" id="rating10" name="rating" value="10" /><label for="rating10" title="5 stars"></label>
                    <input type="radio" id="rating9" name="rating" value="9" /><label class="half" for="rating9" title="4 1/2 stars"></label>
                    <input type="radio" id="rating8" name="rating" value="8" /><label for="rating8" title="4 stars"></label>
                    <input type="radio" id="rating7" name="rating" value="7" /><label class="half" for="rating7" title="3 1/2 stars"></label>
                    <input type="radio" id="rating6" name="rating" value="6" /><label for="rating6" title="3 stars"></label>
                    <input type="radio" id="rating5" name="rating" value="5" /><label class="half" for="rating5" title="2 1/2 stars"></label>
                    <input type="radio" id="rating4" name="rating" value="4" /><label for="rating4" title="2 stars"></label>
                    <input type="radio" id="rating3" name="rating" value="3" /><label class="half" for="rating3" title="1 1/2 stars"></label>
                    <input type="radio" id="rating2" name="rating" value="2" /><label for="rating2" title="1 star"></label>
                    <input type="radio" id="rating1" name="rating" value="1" /><label class="half" for="rating1" title="1/2 star"></label>
                </fieldset>

                <p class="comment"></p>
            </div>
           

        </template>

            <div class ="buttons__pagination">
                <button type="button" class="btn btn--accent" id="btn__prev_comm">Prev</button>
                <button type="button" class="btn btn--accent" id="btn__next_comm">Next</button>
            </div>
    </section>

<?php
    require __DIR__ . '/../templates/footer.php';
?>
