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

//Auth
Route::get('/login-admin', [AuthController::class, "index"])->name("login");
Route::post('/auth/login', [AuthController::class, "login"])->name("authLogin");
Route::get('/auth/login', function () {
    return redirect()->route("index");
});
Route::get('/logout', [AuthController::class, "logout"])->middleware("auth")->name("logout");

//Bookings
Route::get("/", [BookingController::class, "index"])->name("index");
Route::get("/checkHarga", [BookingController::class, "checkHarga"])->name("checkHarga");
Route::get("/prosesCheckHarga/{tambahWaktu}/{package}/{jumlah}/{tambahan_tirai}/{tambahan_spotlight}", [BookingController::class, "prosesCheckHarga"])->name("prosesCheckHarga");
Route::get("/booking", [BookingController::class, "booking"])->name("booking");
Route::post("/strukBooking", [BookingController::class, "strukBooking"])->name("strukBooking");
Route::post("/backToBooking", [BookingController::class, "backToBooking"])->name("backToBooking");
Route::post("/storeBooking", [BookingController::class, "store"])->name("storeBooking");
Route::get("/timeBooking/{date}", [BookingController::class, "time"])->name("timeBookings");


//Admin
Route::get("/admin", [BookingController::class, "indexAdmin"])->middleware("auth")->name("indexAdmin");
Route::get("/harga", [HargaController::class, "index"])->middleware("auth")->name("harga");
// Route::get("/send/reminder", [BookingController::class, "sendReminder"])->middleware("auth")->name("sendReminder");
Route::get("/waktuBukaStudio", [WaktuController::class, "index"])->middleware("auth")->name("waktuBukaStudio");
Route::delete("/deleteWaktuBuka/{id}/{deleteAll}/{status}", [WaktuController::class, "deleteWaktuBuka"])->middleware("auth")->name("deleteWaktuBuka");
Route::post("/addWaktuBuka", [WaktuController::class, "addWaktuBuka"])->middleware("auth")->name("addWaktuBuka");
Route::delete("/deleteWaktuOperasional/{id}", [WaktuController::class, "deleteWaktuOperasional"])->middleware("auth")->name("deleteWaktuOperasional");
Route::post("/addWaktuOperasional", [WaktuController::class, "addWaktuOperasional"])->middleware("auth")->name("addWaktuOperasional");
Route::post("/updateHargaPaket", [HargaController::class, "updateHargaPaket"])->middleware("auth")->name("updateHargaPaket");
Route::post("/updateHargaPerOrang", [HargaController::class, "updateHargaPerOrang"])->middleware("auth")->name("updateHargaPerOrang");
Route::delete("/destroyBooking", [BookingController::class, "destroy"])->middleware("auth")->name("destroyBooking");
Route::delete("/destroyOneBooking", [BookingController::class, "destroyOne"])->middleware("auth")->name("destroyOneBooking");
Route::post("booking/addNote/{id}", [BookingController::class, "addNote"])->middleware("auth")->name("booking.addNote");
Route::post("photobox/addNote/{id}", [PhotoboxController::class, "addNote"])->middleware("auth")->name("photobox.addNote");

// Photobox
Route::get("/booking-photobox", [PhotoboxController::class, "index"])->name("booking-photobox");
Route::get("/checkHargaPhotobox", [PhotoboxController::class, "checkHarga"])->name("checkHargaPhotobox");
Route::get("/timeBookingPhotobox/{date}", [PhotoboxController::class, "time"])->name("timeBookingsPhotobox");
Route::post("/strukBookingPhotobox", [PhotoboxController::class, "strukBookingPhotobox"])->name("strukBookingPhotobox");
Route::post("/storeBookingPhotobox", [PhotoboxController::class, "store"])->name("storeBookingPhotobox");
Route::post("/backToBookingPhotobox", [PhotoboxController::class, "backToBooking"])->name("backToBookingPhotobox");
Route::delete("/destroyBookingPhotobox", [PhotoboxController::class, "destroy"])->middleware("auth")->name("destroyBookingPhotobox");
Route::delete("/destroyOneBookingPhotobox", [PhotoboxController::class, "destroyOne"])->middleware("auth")->name("destroyOneBookingPhotobox");
Route::get("/adminPhotobox", [PhotoboxController::class, "indexAdmin"])->middleware("auth")->name("indexAdminPhotobox");

Route::get("/downloadPhoto/{id}", [PhotoboxController::class, "downloadPhoto"])->middleware("auth")->name("downloadPhoto");
Route::get("/hapusSampah", [PhotoboxController::class, "hapusSampah"])->middleware("auth")->name("hapusSampah");

// Admin Cashier
Route::get('/cashierPhotobox', [PhotoboxController::class, "cashierPhotobox"])->name('kasirPhotobox');
Route::get('/cashierAdmin', [BookingController::class, "adminCashier"])->name('kasirSelfPhoto');

//Photobooth - Home
Route::get("/photobooth", [PhotoboothController::class, "index"])->name("photobooth");
Route::post("/photobooth/store", [PhotoboothController::class, "store"])->name("photobooth.store");
Route::get("photobooth/template", [PhotoboothTemplateController::class, "index"])->name("photobooth.template");
Route::get("photobooth/final", [PhotoboothController::class, "final"])->name("photobooth.final");

