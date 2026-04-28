<?php
    $page_title = 'Giw — Acasă';
    $page_css   = 'home';
    require __DIR__ . '/../templates/header.php';
?>

<section class="home__container">
   <section class="hero-section">
        <div class="hero-section__text">
            <span class="hero-section__badge">Recomandări inteligente</span>
            <h1 class="hero-section__title">
                Găsește cadoul perfect <span class="hero-section__title-accent">pentru orice ocazie.</span>
            </h1>
            <p class="hero-section__lead">
                Povestește-ne despre ei — hobby-urile lor, bugetul tău, ocazia.
                Vom alege cu grijă cadouri care chiar le vor plăcea.
            </p>

            <div class="hero-section__actions">
                <a href="/recomandare.php" class="btn btn--primary">Găsește cadou</a>
                <a href="#categories_cards" class="btn btn--ghost">Vezi exemple</a>
            </div>
        </div>

        <div class="hero-section__image">
            <img src="/images/logo_hero_section.png" alt="Cutie cadou" width="400" height="400">
        </div>
   </section>

   <section id="categories_cards" class ="categories_cards" >

   </section>
</section>

<?php 
    require __DIR__ . '/../templates/footer.php';
?>