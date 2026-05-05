<?php
    $page_title = 'Rezultate php';
    $page_css   = 'rezultate';
    $page_js = 'rezultate';
    require __DIR__ . '/../templates/header.php';
?>
    <section class="recs__gifts">
          <div id="result__header">
            <h1>Cadouri:</h1>
            <h2>Uite câteva recomandări de cadouri pe gusturile tale:</h2>
         </div>
        
         <template id="result__gift">
                <a href ="" class ="card card__gift" id="gift__link">
                    <img src="" alt="" class ="card__image">
                    <p class="card__title"></p>
                    <p class="card__desc card__desc__gift"></p>
                    <p class="card__desc card__price__gift"></p>
                    <span class="btn btn--primary">Vezi detalii cadou</span>
                </a>
            </template>
            
         <div class="result__gifts" id="result__gifts"></div>

         <div class ="buttons__pagination">
            <button type="button" class="btn btn--accent" id="btn__prev">Prev</button>
            <button type="button" class="btn btn--accent" id="btn__next">Next</button>
         </div>
    </section>

<?php 
    require __DIR__ . '/../templates/footer.php';
?>