<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\LawyerProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Website\WebsiteHomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/specializations', [WebsiteHomeController::class, 'getSpecializations'])->name('specializations.list');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('lawyer/profile/edit', [LawyerProfileController::class, 'edit'])->name('lawyer.profile.edit');
    Route::put('lawyer/profile', [LawyerProfileController::class, 'update'])->name('lawyer.profile.update');
    Route::put('lawyer/profile/password', [LawyerProfileController::class, 'updatePassword'])->name('lawyer.profile.password');
    Route::get('lawyer/view', [LawyerProfileController::class, 'show'])->name('lawyer.profile.show');
});




Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('lawyer/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('lawyer/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Lawyers Resource
    Route::resource('lawyers', LawyerController::class);

    // Blog Posts Resource
    Route::resource('blog-posts', BlogController::class);

    // Reviews
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::patch('/reviews/{review}/status', [ReviewController::class, 'updateStatus'])->name('reviews.status');
});



require __DIR__ . '/auth.php';
