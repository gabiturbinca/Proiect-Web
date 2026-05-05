<?php
    $page_title = 'Pagina cadou';
    $page_css   = 'cadou';
    $page_js = 'cadou';
    require __DIR__ . '/../templates/header.php';
?>

    <section class="gift__container">
        <div id="gift__header">
            <h1>Buchet Trandafiri Rosii</h1>
            <img src="https://cdn.pixabay.com/photo/2014/04/14/20/11/pink-324175_1280.jpg" alt="Buchet Trandafiri Rosii">
        </div>

        <div class="gift__details">
            <p class="gift__description"><strong>Descriere: </strong>Buchet de 25 trandafiri rosii</p>
            <p class="gift_price">Pret: 149.99</p>
            <p class="gift__brand__name">Brand: FloraExpress</p>
            <p class="gift__category">Categorie: Flori</p>
        </div>

        <div class="gift__buttons">
            <button class="btn btn--primary">Trimite cadou</button>
            <button class="btn btn--ghost">Adaugă la favorite</button>
        </div>
    </section>

<?php
    require __DIR__ . '/../templates/footer.php';
?>