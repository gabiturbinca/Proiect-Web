<?php
    $page_title = 'Form recomandare';
    $page_css   = 'recomandare';
    $page_js = 'recomandare';
    require __DIR__ . '/../templates/header.php';
?>

    <section class ="form__cadouri">
         <div id="form__header">
            <h1>Form:</h1>
            <h2>Find the perfect gift for any ocassion</h2>
         </div>
        

        <form method="GET" action="/rezultate.php">
          <fieldset class="quiz__group">
            <legend class="quiz__legend">What's your budget?</legend>
            <div class="quiz__row">
                <div class="field">
                <label class="field__label" for="min-price">Minimum price(lei)</label>
                <input class="field__input" type="number" id="min-price" name="min" min="0" placeholder="50" step="5">
                </div>
                <div class="field">
                <label class="field__label" for="max-price">Maximum price (lei)</label>
                <input class="field__input" type="number" id="max-price" name="max" min="0" placeholder="500" step="5">
                </div>
            </div>
        </fieldset>

            <fieldset class="quiz__group">
                <legend class="quiz__legend">From which categories do you want the gift?</legend>
                
                
                <div class="quiz__options" id="quiz__options__category">
                    <template id="category_template">
                        <article class="quiz__checkbox">
                            <input type="checkbox" value="" class="checkbox__input" name="" id="">
                            <label for="" class="checkbox__label"></label>
                        </article>
                    </template>
                </div>
                   
               
            </fieldset>

            <fieldset class="quiz__group">
                <legend class="quiz__legend">Do you have any preferences for the brand?</legend>
                
                <div class="quiz__options" id="quiz__options__brand">
                    <template id="brand_template">
                        <article class="quiz__checkbox">
                            <input type="checkbox" value="" class="checkbox__input" name="" id="">
                            <label for="" class="checkbox__label"></label>
                        </article>
                    </template>
                </div>
            </fieldset>

            <fieldset class="quiz__group">
                <legend class="quiz__legend">Add other details:</legend>

                <div class="quiz__options" id="quiz__options__tag">
                    <template id="tag_template">
                        <article class="quiz__checkbox">
                            <input type="checkbox" value="" class="checkbox__input" name="" id="">
                            <label for="" class="checkbox__label"></label>
                        </article>
                    </template>
                 </div>
            </fieldset>

            <button type="submit"  class="btn btn--accent">Search</button>
        </form>
    </section>
<?php 
    require __DIR__ . '/../templates/footer.php';
?>