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
                    <p><strong>Description: </strong><span class="gift__description"></span></p>
                    <p><strong>Price: </strong><span class="gift__price"></span></p>
                    <p><strong>Brand: </strong><span class="gift__brand"></span></p>
                    <p><strong>Category: </strong><span class="gift__category"></span></p>
                    <div class="gift__specs"></div>
                </div>
                <?php
                if($isLoggedIn){
                    ?>
                        <div class="gift__buttons">
                            <button class="btn btn--primary" id="send__gift">Send gift</button>
                        </div>
                    <?php
                 }
                ?>
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
                <a href ="" class ="card card__gift gift__link">
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

        <?php if($isLoggedIn): ?>
            <form class="review__form" id="review__form" data-username="<?= htmlspecialchars($payload['username']) ?>">
                <div id="review_form__title">
                    <h1 id="review_form__heading">Leave a review:</h1>
                </div>

                <div class="field">
                    <span class="field__label">Rating:</span>
                    <fieldset class="rate-mobile">
                        <input type="radio" id="rating10" name="rating" value="10" /><label for="rating10" title="5 stars"></label>
                        <input type="radio" id="rating9"  name="rating" value="9"  /><label class="half" for="rating9"  title="4 1/2 stars"></label>
                        <input type="radio" id="rating8"  name="rating" value="8"  /><label for="rating8"  title="4 stars"></label>
                        <input type="radio" id="rating7"  name="rating" value="7"  /><label class="half" for="rating7"  title="3 1/2 stars"></label>
                        <input type="radio" id="rating6"  name="rating" value="6"  /><label for="rating6"  title="3 stars"></label>
                        <input type="radio" id="rating5"  name="rating" value="5"  /><label class="half" for="rating5"  title="2 1/2 stars"></label>
                        <input type="radio" id="rating4"  name="rating" value="4"  /><label for="rating4"  title="2 stars"></label>
                        <input type="radio" id="rating3"  name="rating" value="3"  /><label class="half" for="rating3"  title="1 1/2 stars"></label>
                        <input type="radio" id="rating2"  name="rating" value="2"  /><label for="rating2"  title="1 star"></label>
                        <input type="radio" id="rating1"  name="rating" value="1"  /><label class="half" for="rating1"  title="1/2 star"></label>
                    </fieldset>
                </div>

                <div class="field">
                    <label class="field__label" for="comment">Comment:</label>
                    <textarea class="field__input" id="comment" name="comment" placeholder="Tell us what you think about the product.." required></textarea>
                </div>

                <span id="message__review"></span>

                <div class="buttons__pagination">
                    <button type="submit" class="btn btn--primary" id="btn__submit__review">Send review</button>
                    <button type="button" class="btn btn--ghost" id="btn__cancel__edit" hidden>Cancel</button>
                </div>
            </form>
        <?php else: ?>
            <p class="review__login__prompt">
                <a href="/login.php" class="review__login__link">Sign in</a> <span id="second_part_text" >to leave a review</span>
            </p>
        <?php endif; ?>

        <div class="reviews_container"></div>

        <template id="review">
            <div class="review_card">
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

                <div class="review__actions" hidden>
                    <button type="button" class="btn btn--outline review__edit">Modify</button>
                    <button type="button" class="btn btn--ghost review__delete">Delete</button>
                </div>
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
