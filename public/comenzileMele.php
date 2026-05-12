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
                <p class="card__desc card__awb"></p>
                <p class="card__desc card__time"></p>
                <p class="card__desc">Status: <span class="card__status"></span></p>
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