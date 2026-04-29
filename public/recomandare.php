<?php
    $page_title = 'Form recomandare';
    $page_css   = 'recomandare';
    require __DIR__ . '/../templates/header.php';
?>

    <section class ="form__cadouri">
         <div id="form__header">
            <h1>Formular:</h1>
            <h2>Caută cadoul perfect pentru orice ocazie</h2>
         </div>
        

        <form method="GET" action="/rezultate.php">
          <fieldset class="quiz__group">
            <legend class="quiz__legend">Care este bugetul dvs?</legend>
            <div class="quiz__row">
                <div class="field">
                <label class="field__label" for="min-price">Preț minim (lei)</label>
                <input class="field__input" type="number" id="min-price" name="min" min="0" placeholder="50" step="5">
                </div>
                <div class="field">
                <label class="field__label" for="max-price">Preț maxim (lei)</label>
                <input class="field__input" type="number" id="max-price" name="max" min="0" placeholder="500" step="5">
                </div>
            </div>
        </fieldset>

            <fieldset class="quiz__group">
                <legend class="quiz__legend">Din care categorie doriți să fie?</legend>
                
                
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
                <legend class="quiz__legend">Aveți vreo preferință de brand?</legend>
                
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
                <legend class="quiz__legend">Adăugați detalii suplimentare:</legend>

                <div class="quiz__options" id="quiz__options__tag">
                    <template id="tag_template">
                        <article class="quiz__checkbox">
                            <input type="checkbox" value="" class="checkbox__input" name="" id="">
                            <label for="" class="checkbox__label"></label>
                        </article>
                    </template>
                 </div>
            </fieldset>

            <button type="submit"  class="btn btn--accent">Caută</button>
        </form>
    </section>
<?php 
    require __DIR__ . '/../templates/footer.php';
?>