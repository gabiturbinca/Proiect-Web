<?php
    $page_title = 'Giw — Acasă';
    $page_css   = 'home';
    $page_js = 'home';
    require __DIR__ . '/../templates/header.php';
?>

<section class="home__container">
   <section class="hero-section">
        <div class="hero-section__text">
            <span class="hero-section__badge">Intelligent recommandation</span>
            <h1 class="hero-section__title">
                Find the perfect gift <span class="hero-section__title-accent">for every occasion.</span>
            </h1>
            <p class="hero-section__lead">
                Tell us about them — their hobbies, your budget, the occasion.
                We'll choose with great care gifts they will love.
            </p>

            <div class="hero-section__actions">
                <a href="/recomandare.php" class="btn btn--primary">Find gift</a>
                <a href="#categories_cards" class="btn btn--ghost">See examples</a>
            </div>
        </div>

        <div class="hero-section__image">
            <img src="/images/logo_hero_section.png" alt="Cutie cadou" width="400" height="400">
        </div>
   </section>

   <section id="categories_cards" class ="categories_cards" >
        <h2>Recommandations per categories:</h2>
        <section id="categories_only_cards" class ="categories_only_cards">
            <template id ="category-card-template">
                    <a href ="" class ="card card__category">
                    <img src="" alt="" class ="card__image">
                    <p class="card__title"></p>
                    <p class="card__desc"></p>
                    <span class="btn btn--primary">See gifts</span>
                    </a>
            </template>



        </section>
   </section>
</section>

<?php
    require __DIR__ . '/../templates/footer.php';
?>
