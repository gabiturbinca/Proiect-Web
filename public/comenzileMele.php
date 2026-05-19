<?php
    $page_title = 'Comaenzile mele';
    $page_css   = 'comenzileMele';
    $page_js = 'comenzileMele';
    require __DIR__ . '/../templates/header.php';
?>
    <section class="my_commands">
        <div class="my_commands__header">
            <h1>Comenzile mele: </h1>
        </div>

        <template id="commands_template">
            <div class="card" id="card__command">
                <p class="card__desc"><span class="card__label">Cadou:</span> <span class="card__gift_name"></span></p>
                <p class="card__desc"><span class="card__label">Data:</span> <span class="card__time"></span></p>
                <p class="card__desc"><span class="card__label">Adresă:</span> <span class="card__address"></span></p>
                <p class="card__desc"><span class="card__label">Descriere:</span> <span class="card__description"></span></p>
                <p class="card__desc"><span class="card__label">Cantitate:</span> <span class="card__quantity"></span></p>
                <p class="card__desc"><span class="card__label">Status:</span> <span class="card__status"></span></p>
            </div>
        </template>

        <div class="commands_cards" id="commands_cards"></div>

        <div class ="buttons__pagination">
            <button type="button" class="btn btn--accent" id="btn__prev">Prev</button>
            <button type="button" class="btn btn--accent" id="btn__next">Next</button>
         </div>

    </section>
<?php
    require __DIR__ . '/../templates/footer.php';
?>