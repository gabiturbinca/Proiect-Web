<?php
    $page_title = 'Comanda cadou';
    $page_css   = 'comanda';
    $page_js = 'comanda';
    require __DIR__ . '/../templates/header.php';
?>

<section class="order__container">
    <div id="order__title">
        <h1>Comandă cadou: </h1>
        <h2>Comandați acum un cadou de pe platforma noastră, cât încă se află în stoc.</h2>
    </div>

    <div id="gift__container">
        <template id="gift__card">
            <div class="gift__row">
                <div id="gift__header">
                    <img class="gift__image" src="" alt="">
                </div>

                <div id="gift__mini__container">
                    <h1 class="gift__title"></h1>
                    <div class="gift__details">
                        <p><strong>Descriere: </strong><span class="gift__description"></span></p>
                        <p><strong>Pret: </strong><span class="gift__price"></span></p>
                        <p><strong>Brand: </strong><span class="gift__brand"></span></p>
                        <p><strong>Categorie: </strong><span class="gift__category"></span></p>
                    </div>
                    <div class="gift__tags"></div>
                </div>
            </div>
        </template>
    </div>

    <form class="order__form" id="order__form">
                 <div id="order_form__title">
                    <h1>Detalii comandă:</h1>
                </div>

                <div class="field">
                    <label class="field__label" for="address">Adresa :</label>
                    <input class="field__input" type="text" id="address" name="address" required>
                </div>

                <div class="field">
                    <label class="field__label" for="recipient_name">Nume destinatar: </label>
                    <input class="field__input" type="text" id="recipient_name" name="recipient_name" required>
                </div>

                <div class="field">
                    <label class="field__label" for="quantity">Cantitatea :</label>
                    <input class="field__input" type="number" id="quantity" name="quantity" min="1" placeholder="1" step="1" required>
                </div>

                <div class="field">
                    <span class="field__label">Doriți să trimiteți în regim anonim?</span>

                    <div class="order__options">
                        <article class="order__checkbox">
                            <input type="radio" value="true" class="checkbox__input" name="is_anonymous" id="anonymous_yes">
                            <label for="anonymous_yes" class="checkbox__label">DA</label>
                        </article>

                        <article class="order__checkbox">
                            <input type="radio" value="false" class="checkbox__input" name="is_anonymous" id="anonymous_no">
                            <label for="anonymous_no" class="checkbox__label">NU</label>
                        </article>
                    </div>
                </div>

                <div class="field">
                    <label class="field__label" for="description">Alege un mesaj pentru destinatar: </label>
                    <input class="field__input" type="text" id="description" name="description" required>
                </div>

                <span id="message__command"></span>
                <div class ="buttons__pagination">
                    <button type="submit" class="btn btn--primary" id="btn__submit">Comandă!</button>
                </div>


            </form>
</section>
<?php
    require __DIR__ . '/../templates/footer.php';
?>