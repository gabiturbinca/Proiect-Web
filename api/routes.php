<?php



//for gifts
$router->get("/api/gifts", [GiftController::class, "list"]);
$router->get("/api/gifts/{id}", [GiftController::class, "show"]);
$router->get("/api/gifts/category/{id}",[GiftController::class, "listByCategory"]);

//for categories

$router->get("/api/categories", [CategoryController::class, "list"]);
$router->get("/api/categories/{id}", [CategoryController::class, "show"]);   