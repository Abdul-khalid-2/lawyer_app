<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LawyerController;
use App\Http\Controllers\LawyerProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Website\WebsiteHomeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\Website\WebsiteLawyersController;
use App\Http\Controllers\Website\WebsiteReviewController;
use App\Http\Controllers\Website\WebsiteBlogController;

Route::get('/', [WebsiteHomeController::class, 'home'])->name('home');
Route::get('find-lawyers', [WebsiteLawyersController::class, 'index'])->name('find-lawyeres');
Route::get('/how-it-work', [WebsiteHomeController::class, 'howItWork'])->name('website.howItWork');

Route::get('/lawyers', [WebsiteLawyersController::class, 'index'])->name('website.lawyers');
Route::post('/lawyers/load-more', [WebsiteLawyersController::class, 'loadMore'])->name('website.lawyers.load-more');
Route::get('/lawyer/{uuid}/view', [WebsiteLawyersController::class, 'show'])->name('website.lawyers.profile');

Route::post('/lawyers/{uuid}/track-time', [WebsiteLawyersController::class, 'trackTime'])->name('website.track-time');


// Blog Routes
Route::prefix('blog')->group(function () {
    Route::get('/', [WebsiteBlogController::class, 'index'])->name('website.blog.index');
    Route::get('/search', [WebsiteBlogController::class, 'index'])->name('website.blog.search');
    Route::get('/category/{slug}', [WebsiteBlogController::class, 'category'])->name('website.blog.category');
    Route::get('/tag/{tag}', [WebsiteBlogController::class, 'tag'])->name('website.blog.tag');
    Route::get('/author/{uuid}', [WebsiteBlogController::class, 'author'])->name('website.blog.author');
    Route::get('/{slug}', [WebsiteBlogController::class, 'show'])->name('website.blog.show');
});

// blog comments routes
Route::post('/blog/{blogPost}/comments', [CommentController::class, 'store'])->name('website.blog.comments.store');
Route::get('/comments/{comment}/replies', [CommentController::class, 'getReplies'])->name('website.comments.replies');

// Route::get('/specializations', [WebsiteHomeController::class, 'getSpecializations'])->name('specializations.list');
// Route::middleware(['auth', 'verified', 'role:super-admin|school-admin'])->group(function () {});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('lawyer/profile/edit', [LawyerProfileController::class, 'edit'])->name('lawyer.profile.edit');
    Route::put('lawyer/profile', [LawyerProfileController::class, 'update'])->name('lawyer.profile.update');
    Route::put('lawyer/profile/password', [LawyerProfileController::class, 'updatePassword'])->name('lawyer.profile.password');
    Route::get('lawyer/view', [LawyerProfileController::class, 'show'])->name('lawyer.profile.show');

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

    // Blog Categories Routes
    Route::resource('blog-categories', BlogCategoryController::class);

    // Blog Posts Routes
    Route::resource('blog-posts', BlogPostController::class);

    // Education Routes
    Route::resource('educations', EducationController::class);

    // Experience Routes
    Route::resource('experiences', ExperienceController::class);

    // Review routes
    Route::middleware(['auth'])->group(function () {
        Route::post('/lawyers/{lawyerUuid}/reviews', [WebsiteReviewController::class, 'store'])->name('website.reviews.store');
        Route::patch('/reviews/{reviewUuid}/status', [WebsiteReviewController::class, 'updateStatus'])->name('website.reviews.update-status');
        Route::patch('/reviews/{reviewUuid}/toggle-featured', [WebsiteReviewController::class, 'toggleFeatured'])->name('website.reviews.toggle-featured');
        Route::delete('/reviews/{reviewUuid}', [WebsiteReviewController::class, 'destroy'])->name('website.reviews.destroy');
    });
});




require __DIR__ . '/auth.php';
