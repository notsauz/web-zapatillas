<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SneakerController;
use App\Http\Controllers\AdminController;

// Página principal - catálogo de zapatillas
Route::get("/", [SneakerController::class, "index"])->name("catalogo");

// REGISTRO
Route::get("/register", [RegisterController::class, "showForm"])->name("register.form");
Route::post("/register", [RegisterController::class, "register"])->name("register");

// LOGIN
Route::get("/login", [LoginController::class, "showForm"])->name("login");
Route::post("/login", [LoginController::class, "login"])->name("login.submit");

// LOGOUT
Route::post("/logout", [LogoutController::class, "logout"])->name("logout");

// CATÁLOGO - Rutas de zapatillas
Route::get("/catalogo", [SneakerController::class, "index"])->name("catalogo.index");
Route::get("/categoria/{category}", [SneakerController::class, "byCategory"])->name("categoria");
Route::get("/marcas", [SneakerController::class, "allBrands"])->name("marcas.index");
Route::get("/marcas/{brand}", [SneakerController::class, "byBrand"])->name("marcas.show");
Route::get("/buscar", [SneakerController::class, "search"])->name("buscar");
Route::get("/zapatillas/{id}", [SneakerController::class, "show"])->name("sneaker.show");

// API - Zapatillas visitadas recientemente (AJAX)
Route::get("/api/recently-viewed", [SneakerController::class, "getRecentlyViewed"])->name("sneaker.recently-viewed");

// API - Zapatillas más favoritas (AJAX)
Route::get("/api/top-favorites", [SneakerController::class, "topFavoritesAjax"])->name("sneaker.top-favorites.ajax");

// PERFIL (Solo usuarios autenticados)
Route::middleware("auth")->group(function () {
    Route::get("/profile", [ProfileController::class, "edit"])->name("profile.edit");
    Route::get("/profile/favorites", [ProfileController::class, "favorites"])->name("profile.favorites");
    Route::put("/profile", [ProfileController::class, "update"])->name("profile.update");
    Route::post("/profile/password", [ProfileController::class, "changePassword"])->name("profile.password");
    Route::post("/profile/send-verification", [ProfileController::class, "sendVerificationEmail"])->name("profile.send-verification");
    Route::post("/profile/delete-account", [ProfileController::class, "deleteAccount"])->name("profile.delete-account");
    Route::post("/profile/confirm-delete", [ProfileController::class, "confirmDelete"])->name("profile.confirm-delete");

    // Favoritos
    Route::post("/favorites/add", [ProfileController::class, "addFavorite"])->name("favorites.add");
    Route::post("/favorites/remove", [ProfileController::class, "removeFavorite"])->name("favorites.remove");
});

// Email verification (sin autenticación requerida)
Route::get("/verification/verify/{id}/{hash}", [ProfileController::class, "verifyEmail"])->name("verification.verify");

// Dashboard redirect
Route::get("/home", function () {
    return auth()->check() ? view("home") : redirect()->route("login");
})->name("home");

// ADMIN PANEL (Solo admins autenticados)
Route::middleware(["auth", "is_admin"])->group(function () {
    // Dashboard
    Route::get("/admin", [AdminController::class, "index"])->name("admin.dashboard");

    // Gestión de Zapatillas
    Route::get("/admin/sneakers", [AdminController::class, "listSneakers"])->name("admin.sneakers.index");
    Route::get("/admin/sneakers/create", [AdminController::class, "createSneaker"])->name("admin.sneakers.create");
    Route::post("/admin/sneakers", [AdminController::class, "storeSneaker"])->name("admin.sneakers.store");
    Route::get("/admin/sneakers/{id}/edit", [AdminController::class, "editSneaker"])->name("admin.sneakers.edit");
    Route::put("/admin/sneakers/{id}", [AdminController::class, "updateSneaker"])->name("admin.sneakers.update");
    Route::delete("/admin/sneakers/{id}", [AdminController::class, "destroySneaker"])->name("admin.sneakers.destroy");

    // Gestión de Marcas
    Route::get("/admin/brands", [AdminController::class, "listBrands"])->name("admin.brands.index");
    Route::get("/admin/brands/create", [AdminController::class, "createBrand"])->name("admin.brands.create");
    Route::post("/admin/brands", [AdminController::class, "storeBrand"])->name("admin.brands.store");
    Route::get("/admin/brands/{id}/edit", [AdminController::class, "editBrand"])->name("admin.brands.edit");
    Route::put("/admin/brands/{id}", [AdminController::class, "updateBrand"])->name("admin.brands.update");
    Route::delete("/admin/brands/{id}", [AdminController::class, "destroyBrand"])->name("admin.brands.destroy");
});

