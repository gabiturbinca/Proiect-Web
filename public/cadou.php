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
                    <button class="btn btn--primary">Trimite cadou</button>
                    <button class="btn btn--ghost">Adaugă la favorite</button>
                </div>
            </div>
        </div>
    </template>

    <template id="gift__spec">
        <p><strong class="gift__spec__label"></strong><span class="gift__spec__value"></span></p>
    </template>

    <section class="gift__container" id="gift__container"></section>

<?php
    require __DIR__ . '/../templates/footer.php';
?>
