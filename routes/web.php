<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SponsorshipController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::resource('apartments', ApartmentController::class)->parameters(['apartments' => 'apartment:slug']);;
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/messages', [MessageController::class, 'showAllMessages'])->name('dashboard.messages');
});

Route::get('/apartments/{apartment}/sponsorships', [SponsorshipController::class, 'index'])->name('apartments.sponsorships');

Route::post('/apartments/{apartmentId}/sponsorships', [SponsorshipController::class, 'store'])->name('sponsorships.store');

require __DIR__ . '/auth.php';
