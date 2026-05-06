<?php



//for gifts
$router->get("/api/gifts", [GiftController::class, "index"]);
$router->get("/api/gifts/{id}", [GiftController::class, "show"]);
$router->get("/api/gifts/category/{id}",[GiftController::class, "indexByCategory"]);

//for categories

$router->get("/api/categories", [CategoryController::class, "index"]);
$router->get("/api/categories/{id}", [CategoryController::class, "show"]);   
$router->get("/api/categories-short", [CategoryController::class,"indexShort"]);
//for tags

$router->get("/api/tags", [TagController::class,"index"]);

//for brands
$router->get("/api/brands", [BrandController::class,"index"]);

//for form

$router->get("/api/forms", [FormController::class,"index"]);

//for user
$router->get("/api/users", [UserController::class, "index"]);
$router->get("/api/users/{id}", [UserController::class, "show"]);