<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HargaController;
use App\Http\Controllers\WaktuController;
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
Route::get("/idcard/template", [PhotoboothController::class, "idcard_template"])->name("photobooth.idcard.template");

//Photobooth - Admin
Route::get("admin/template", [PhotoboothTemplateController::class, "index_admin"])->middleware("auth")->name("photobooth.template.admin");
Route::get("admin/template/create", [PhotoboothTemplateController::class, "create"])->middleware("auth")->name("photobooth.template.create");
Route::get("admin/template/edit/{id}", [PhotoboothTemplateController::class, "edit"])->middleware("auth")->name("photobooth.template.edit");
Route::post("admin/template", [PhotoboothTemplateController::class, "store"])->middleware("auth")->name("photobooth.template.store");
Route::post("admin/template/edit", [PhotoboothTemplateController::class, "update"])->middleware("auth")->name("photobooth.template.update");
Route::delete("admin/template/delete/{id}", [PhotoboothTemplateController::class, "destroy"])->middleware("auth")->name("photobooth.template.destroy");
