<?php

use App\Http\Controllers\AdminStoreController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\OwnerStoreController;
use App\Http\Controllers\Template\Section\HeroSectionController;
use App\Http\Controllers\Product\Image\ProductImageController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Store\Image\StoreImageController;
use App\Http\Controllers\Store\StoreController;
use App\Http\Controllers\Template\Section\CalltoactionSectionController;
use App\Http\Controllers\Template\Section\FooterSectionController;
use App\Http\Controllers\Template\Section\HeroAboutUsSectionController;
use App\Http\Controllers\Template\Section\HistorySectionController;
use App\Http\Controllers\Template\Section\ProductSectionController;
use App\Http\Controllers\Template\Section\StoreLocationSectionController;
use App\Http\Controllers\Template\Section\StrengthSectionController;
use App\Http\Controllers\Template\Section\TeamSectionController;
use App\Http\Controllers\Template\TemplateController;
use App\Http\Controllers\Template\TemplateLinkController;
use App\Http\Controllers\TemplateCategoryController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\UserController;
use App\Models\Template\TemplateLink;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get("hello", function () {
    return ["message" => "Halo dek"];
});

Route::get("administrator/stores",  [AdminStoreController::class, "index"]);
Route::get("store_owner/stores",  [OwnerStoreController::class, "index"]);


Route::get("profile", [ProfileController::class, 'index']);
Route::put("profile/change-password", [ProfileController::class, 'updatePassword'])->name("profile.password.update");
Route::put("profile/change-info", [ProfileController::class, 'update'])->name("profile.update");
Route::delete("profile/delete-user", [ProfileController::class, 'destroy'])->name("profile.delete");

Route::controller(AuthController::class)->prefix("auth")->group(function () {
    Route::post('register', "register")->name("auth.register");
    Route::post('login', "login")->name("auth.login");
    Route::post('refresh-token', "refresh")->name("auth.refresh");
    Route::get('me', "me")->name("auth.me");
    Route::delete('logout', "logout")->name("auth.logout");
});

// Route::resource("stores", StoreController::class)->names(["store" => "store.add", "update" => "store.update"]);
Route::resource("users", UserController::class)->names(["update" => "user.update"]);
Route::resource("employees", EmployeeController::class)->names(["store" => "employee.add", "update" => "employee.update"]);
Route::resource("testimonials", TestimonialController::class)->names(["store" => "testimonial.add", "update" => "testimonial.update"]);
Route::resource("certifications", CertificationController::class)->names(["store" => "certification.add", "update" => "certification.update"]);

Route::get("templates/{slug?}", [TemplateController::class, "index"]);
Route::get("template/{id}", [TemplateController::class, "show"]);
Route::resource("templates", TemplateController::class)->names(["store" => "template.add", "update" => "template.update"])->except(["index", "show"]);

Route::resource("category/templates", TemplateCategoryController::class)->names(["store" => "template.category.add", "update" => "template.category.update"]);
Route::resource("template-links", TemplateLinkController::class)->names(["store" => "templateLink.add", "update" => "templateLink.update"]);


Route::prefix("sections")->group(function () {
    Route::resource("hero", HeroSectionController::class)->names(["store" => "template.section.hero.add", "update" => "template.section.hero.update"]);
    Route::resource("footer", FooterSectionController::class)->names(["store" => "template.section.footer.add", "update" => "template.section.footer.update"]);
    Route::resource("calltoaction", CalltoactionSectionController::class)->names(["store" => "template.section.calltoaction.add", "update" => "template.section.calltoaction.update"]);
    Route::resource("strength", StrengthSectionController::class)->names(["store" => "template.section.strength.add", "update" => "template.section.strength.update"]);
    Route::resource("history", HistorySectionController::class)->names(["store" => "template.section.history.add", "update" => "template.section.history.update"]);
    Route::resource("heroAboutUs", HeroAboutUsSectionController::class)->names(["store" => "template.section.heroAboutUs.add", "update" => "template.section.heroAboutUs.update"]);
    Route::resource("product", ProductSectionController::class)->names(["store" => "template.section.product.add", "update" => "template.section.product.update"]);
    Route::resource("storeLocation", StoreLocationSectionController::class)->names(["store" => "template.section.storeLocation.add", "update" => "template.section.storeLocation.update"]);
    Route::resource("team", TeamSectionController::class)->names(["store" => "template.section.team.add", "update" => "template.section.team.update"]);
});

Route::prefix("stores")->group(function () {
    Route::resource("image", StoreImageController::class)->names(["store" => "store.image.add", "update" => "store.image.update"]);
    Route::resource("/", StoreController::class)->names(["store" => "store.add"])->except(["show", "update", 'destroy']);
    Route::get("{id}", [StoreController::class, "show"]);
    Route::put("{id}", [StoreController::class, "update"])->name("store.update");
    Route::delete("{id}", [StoreController::class, "destroy"])->name("store.delete");
});

Route::prefix("products")->group(function () {
    Route::resource("image", ProductImageController::class)->names(["store" => "product.image.add", "update" => "product.image.update"]);
    Route::resource("/", ProductController::class)->names(["store" => "product.add"])->except(["show", "update", 'destroy']);
    Route::get("{id}", [ProductController::class, "show"]);
    Route::put("{id}", [ProductController::class, "update"])->name("product.update");
    Route::delete("{id}", [ProductController::class, "destroy"])->name("product.delete");
});
