<?php


//pentru export, e folosit ca sa dai import 
$router->get("/api/admin/export/gifts", [AdminExportController::class, "gifts"],
 [AuthMiddleware::class, AdminMiddleware::class]);
$router->get("/api/admin/export/categories", [AdminExportController::class, "categories"],
 [AuthMiddleware::class, AdminMiddleware::class]);

//mai trebuie facut acelasi lucru pentru import
$router->post("/api/admin/import/gifts", [AdminImportController::class, "gifts"],
[AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);
$router->post("/api/admin/import/categories", [AdminImportController::class, "categories"],
[AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);

// for reports
$router->get("/api/admin/reports", [AdminReportController::class, "generate"],
    [AuthMiddleware::class, AdminMiddleware::class]);

//orders for userls

$router->post("/api/orders", [OrderController::class,"create"], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->get("/api/orders", [OrderController::class, "index"], [AuthMiddleware::class]);
$router->get("/api/orders/{id}", [OrderController::class,"show"], [AuthMiddleware::class]);
$router->patch("/api/orders/{id}/cancel", [OrderController::class,"cancel"], [AuthMiddleware::class, CsrfMiddleware::class]);

//orders for admins
$router->get("/api/admin/orders", [AdminOrderController::class,"index"], [AuthMiddleware::class, AdminMiddleware::class]);
$router->patch("/api/admin/orders/{id}/status",[AdminOrderController::class, "changeStatus"], [AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);

//for gift recs
$router->get("/api/gifts/recommend", [RecommendationController::class, "recommend"]);

//for gifts
$router->get("/api/gifts", [GiftController::class, "index"]);
$router->get("/api/gifts/{id}", [GiftController::class, "show"]);
$router->get("/api/gifts/category/{id}",[GiftController::class, "indexByCategory"]);
$router->get("/api/gifts/{id}/related", [GiftController::class, "showRelated"]);
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
$router->post("/api/auth/login", [AuthController::class, "login"],[RateLimiterMiddleware::class]);

// auth cu middleware
$router->get("/api/auth/me", [AuthController::class, "me"], [AuthMiddleware::class]);
$router->post("/api/auth/logout", [AuthController::class, "logout"], [AuthMiddleware::class, CsrfMiddleware::class]);

// reviews — public
$router->get("/api/gifts/{id}/reviews", [ReviewController::class, "index"]);

// reviews — authenticated
$router->post("/api/gifts/{id}/reviews", [MyReviewController::class, "create"], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->put("/api/reviews/{id}", [MyReviewController::class, "update"], [AuthMiddleware::class, CsrfMiddleware::class]);
$router->delete("/api/reviews/{id}", [MyReviewController::class, "delete"], [AuthMiddleware::class, CsrfMiddleware::class]);

// admin gifts
$router->post("/api/admin/gifts", [GiftController::class, "create"], [AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);
$router->patch("/api/admin/gifts/{id}", [GiftController::class, "update"], [AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);
$router->delete("/api/admin/gifts/{id}", [GiftController::class, "delete"], [AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);
$router->post("/api/admin/gifts/{id}/image", [GiftController::class, "uploadImage"], [AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);
$router->delete("/api/admin/gifts/{id}/image", [GiftController::class, "deleteImage"], [AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);

// admin categories
$router->post("/api/admin/categories", [CategoryController::class, "create"], [AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);
$router->patch("/api/admin/categories/{id}", [CategoryController::class, "update"], [AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);
$router->delete("/api/admin/categories/{id}", [CategoryController::class, "delete"], [AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);

//context
$router->get("/api/admin/contexts", [ContextController::class,"index"],[AuthMiddleware::class, AdminMiddleware::class]);
//circumstance
$router->get("/api/admin/circumstances", [CircumstanceController::class,"index"],[AuthMiddleware::class, AdminMiddleware::class]);
//pass change cand logat de catre user
$router->post("/api/auth/password", [AuthController::class,"changePassword"], [AuthMiddleware::class,CsrfMiddleware::class]);

//admin reseteaza direct (fara request)
$router->post("/api/admin/users/{id}/password-reset",
    [AdminAuthController::class, "resetPassword"],
    [AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);

//user cere reset (cand nu e logat, a uitat parola)
$router->post("/api/auth/password/reset-request",
    [AuthController::class, "requestReset"]);

//admin vede pending requests
$router->get("/api/admin/password-reset-requests",
    [AdminAuthController::class, "listPendingResets"],
    [AuthMiddleware::class, AdminMiddleware::class]);

//admin aproba sau respinge un request
$router->post("/api/admin/password-reset-requests/{id}/approve",
    [AdminAuthController::class, "approveReset"],
    [AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);

$router->post("/api/admin/password-reset-requests/{id}/deny",
    [AdminAuthController::class, "denyReset"],
    [AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);
$router->get("/api/admin/unsplash", [UnsplashController::class, "search"], 
    [AuthMiddleware::class, AdminMiddleware::class]);


$router->post("/api/admin/imports/dummyjson", [DummyJsonController::class, "import"],
    [AuthMiddleware::class, CsrfMiddleware::class, AdminMiddleware::class]);