<?php

use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\BraintreeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SponsorshipController;
use App\Models\ApartmentSponsorship;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/apartments/{slug}/sponsorships/{id}', [SponsorshipController::class, 'index'])->name('apartments.sponsorships');

Route::post('/apartments/{apartmentId}/sponsorships', [SponsorshipController::class, 'store'])->name('sponsorships.store');

Route::post('/braintree/token', [BraintreeController::class, 'token'])->name('braintree.token');
Route::post('/braintree/payment', [BraintreeController::class, 'payment'])->name('payment.process');

Route::get('/braintree/payment/success', function () {
    $apartmentSponsorshipId = Session::get('apartmentSponsorshipId');
    $apartmentSponsorship = ApartmentSponsorship::with(['apartment', 'sponsorship'])
        ->find($apartmentSponsorshipId);

    return view('pages.braintree.payment', compact('apartmentSponsorship'));
})->name('payment.success');

require __DIR__ . '/auth.php';
