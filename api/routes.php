<?php

//orders for userls

$router->post("/api/orders", [OrderController::class,"create"], [AuthMiddleware::class]);
$router->get("/api/orders", [OrderController::class, "index"], [AuthMiddleware::class]);
$router->get("/api/orders/{id}", [OrderController::class,"show"], [AuthMiddleware::class]);
$router->patch("/api/orders/{id}/cancel", [OrderController::class,"cancel"], [AuthMiddleware::class]);

//orders for admins
$router->get("/api/admin/orders", [AdminOrderController::class,"index"], [AuthMiddleware::class, AdminMiddleware::class]);
$router->patch("/api/admin/orders/{id}/status",[AdminOrderController::class, "changeStatus"], [AuthMiddleware::class, AdminMiddleware::class]);

//for gift recs
$router->get("/api/gifts/recommend", [RecommendationController::class, "recommend"]);

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

//auth
$router->post("/api/auth/register", [AuthController::class, "register"]);
$router->post("/api/auth/login", [AuthController::class, "login"]);

// auth cu middleware
$router->get("/api/auth/me", [AuthController::class, "me"], [AuthMiddleware::class]);
$router->post("/api/auth/logout", [AuthController::class, "logout"], [AuthMiddleware::class]);

// reviews
$router->get("/api/gifts/{id}/reviews", [ReviewController::class, "index"]);
$router->post("/api/gifts/{id}/reviews", [ReviewController::class, "create"], [AuthMiddleware::class]);
$router->put("/api/reviews/{id}", [ReviewController::class, "update"], [AuthMiddleware::class]);
$router->delete("/api/reviews/{id}", [ReviewController::class, "delete"], [AuthMiddleware::class]);

// admin gifts
$router->post("/api/admin/gifts", [GiftController::class, "create"], [AuthMiddleware::class, AdminMiddleware::class]);
$router->patch("/api/admin/gifts/{id}", [GiftController::class, "update"], [AuthMiddleware::class, AdminMiddleware::class]);
$router->delete("/api/admin/gifts/{id}", [GiftController::class, "delete"], [AuthMiddleware::class, AdminMiddleware::class]);
$router->post("/api/admin/gifts/{id}/image", [GiftController::class, "uploadImage"], [AuthMiddleware::class, AdminMiddleware::class]);
$router->delete("/api/admin/gifts/{id}/image", [GiftController::class, "deleteImage"], [AuthMiddleware::class, AdminMiddleware::class]);

// admin categories
$router->post("/api/admin/categories", [CategoryController::class, "create"], [AuthMiddleware::class, AdminMiddleware::class]);
$router->patch("/api/admin/categories/{id}", [CategoryController::class, "update"], [AuthMiddleware::class, AdminMiddleware::class]);
$router->delete("/api/admin/categories/{id}", [CategoryController::class, "delete"], [AuthMiddleware::class, AdminMiddleware::class]);