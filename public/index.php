<?php
//pt env
require_once __DIR__ . '/../config/env.php';
loadEnv(__DIR__ . '/../.env');


//pt exceptii
require_once __DIR__ . '/../config/ExceptionHandler.php';
set_exception_handler([ExceptionHandler::class, 'handleException']);
set_error_handler([ExceptionHandler::class,'errorHandler']);

//general clase
require_once __DIR__ . '/../utils/helpers.php';
require_once __DIR__ . '/../config/autoload.php';
require_once __DIR__ . '/../api/Router.php';
require_once __DIR__ . '/../config/Container.php';
//pt router

$container = new Container();
$router = new Router($container);

require_once __DIR__ . '/../api/routes.php';
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// 
try {
    $result = $router -> dispatch($method, $uri);
    Response::success($result);
}
catch (NotFoundException $e) {
    Response::error($e->getMessage(),404);
}
catch (Throwable $e) {
    ExceptionHandler::handleException($e);
}
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
        <h2>Recomandări pe categorii:</h2>
        <section id="categories_only_cards" class ="categories_only_cards">
            <template id ="category-card-template">
                    <a href ="" class ="card card__category">
                    <img src="" alt="" class ="card__image">
                    <p class="card__title"></p>
                    <p class="card__desc"></p>
                    <span class="btn btn--primary">Vezi cadourile</span>
                </a>
            </template>
           


        </section>
   </section>
</section>

<?php 
    require __DIR__ . '/../templates/footer.php';
?>
