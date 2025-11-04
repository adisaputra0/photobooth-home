<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\WaktuController;
use App\Http\Controllers\IDCardController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PhotoboxController;
use App\Http\Controllers\PhotoboothController;
use App\Http\Controllers\PhotoboothTemplateController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//Photobooth - Home
Route::get("/", [PhotoboothController::class, "index"])->name("photobooth");
Route::post("/store", [PhotoboothController::class, "store"])->name("photobooth.store");
Route::get("template", [PhotoboothTemplateController::class, "index"])->name("photobooth.template");
Route::get("final", [PhotoboothController::class, "final"])->name("photobooth.final");
Route::post('/save-photo', [PhotoboothController::class, 'savePhoto'])->name('photobooth.savePhoto');
Route::get("gantunganKunci", [PhotoboothController::class, "gantunganKunci"])->name("photobooth.gantunganKunci");


Route::get("/admin", [PhotoboothController::class, "admin"])->name("admin");

//Photobooth - Admin
Route::get("admin/template", [PhotoboothTemplateController::class, "index_admin"])->name("photobooth.template.admin");
Route::get("admin/template/create", [PhotoboothTemplateController::class, "create"])->name("photobooth.template.create");
Route::get("admin/template/edit/{id}", [PhotoboothTemplateController::class, "edit"])->name("photobooth.template.edit");
Route::post("admin/template", [PhotoboothTemplateController::class, "store"])->name("photobooth.template.store");
Route::post("admin/template/edit", [PhotoboothTemplateController::class, "update"])->name("photobooth.template.update");
Route::delete("admin/template/delete/{id}", [PhotoboothTemplateController::class, "destroy"])->name("photobooth.template.destroy");

//ID Card
Route::get("/idcard/template", [IDCardController::class, "index"])->name("idcard.template");

//ID Card - Admin
Route::get("admin/idcard/template", [IDCardController::class, "index_admin"])->name("idcard.template.admin");
Route::get("admin/idcard/template/create", [IDCardController::class, "create"])->name("idcard.template.create");
Route::get("admin/idcard/template/edit/{id}", [IDCardController::class, "edit"])->name("idcard.template.edit");
Route::post("admin/idcard/template", [IDCardController::class, "store"])->name("idcard.template.store");
Route::post("admin/idcard/template/edit", [IDCardController::class, "update"])->name("idcard.template.update");
Route::delete("admin/idcard/template/delete/{id}", [IDCardController::class, "destroy"])->name("idcard.template.destroy");
