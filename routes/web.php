<?php

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
use App\Http\Controllers\Website\WebsiteCommentController;

Route::get('/', [WebsiteHomeController::class, 'home'])->name('home');
Route::get('find-lawyers', [WebsiteLawyersController::class, 'index'])->name('find-lawyeres');
Route::get('/how-it-work', [WebsiteHomeController::class, 'howItWork'])->name('website.howItWork');
Route::get('/about', [WebsiteHomeController::class, 'about'])->name('website.about');

// NOTE: public listing lives at /find-lawyers (find-lawyeres); /lawyers is the admin resource below
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
Route::post('/blog/{blogPost}/comments', [WebsiteCommentController::class, 'store'])->name('website.blog.comments.store');
Route::get('/comments/{comment}/replies', [WebsiteCommentController::class, 'getReplies'])->name('website.comments.replies');

// Public CMS pages (About, Terms, Privacy, FAQ...)
Route::get('/page/{slug}', [\App\Http\Controllers\PageController::class, 'show'])->name('website.page');

// Website video routes
Route::prefix('videos')->group(function () {
    Route::get('/', [\App\Http\Controllers\Website\VideoPageController::class, 'index'])->name('website.videos.index');
    Route::get('/{uuid}', [\App\Http\Controllers\Website\VideoPageController::class, 'show'])->name('website.videos.show');
    Route::post('/{uuid}/track-view', [\App\Http\Controllers\Website\VideoPageController::class, 'trackViewTime'])->name('website.videos.track-view');
});

/*
|--------------------------------------------------------------------------
| Authenticated (any role)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard (routes per-role internally)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Review submission from public lawyer profile (any logged-in user)
    Route::post('/lawyers/{lawyerUuid}/reviews', [WebsiteReviewController::class, 'store'])->name('website.reviews.store');
});

/*
|--------------------------------------------------------------------------
| Super Admin only
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:super_admin'])->group(function () {
    // Lawyers Resource
    Route::resource('lawyers', LawyerController::class);

    // Specializations CRUD
    Route::resource('specializations', \App\Http\Controllers\SpecializationController::class)->except(['show']);

    // Blog Categories Routes
    Route::resource('blog-categories', BlogCategoryController::class);

    // CMS Pages
    Route::resource('pages', \App\Http\Controllers\PageController::class)->except(['show']);

    // Admin overview (view all cases / clients / users across the platform)
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('cases', [\App\Http\Controllers\Admin\CaseController::class, 'index'])->name('cases.index');
        Route::get('cases/{case}', [\App\Http\Controllers\Admin\CaseController::class, 'show'])->name('cases.show');

        Route::get('clients', [\App\Http\Controllers\Admin\ClientController::class, 'index'])->name('clients.index');
        Route::get('clients/{client}', [\App\Http\Controllers\Admin\ClientController::class, 'show'])->name('clients.show');

        Route::get('users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('users.index');
        Route::patch('users/{user}/toggle-status', [\App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');
    });

    // Comment moderation
    Route::get('/blog-posts/{id}/comments', [CommentController::class, 'comments'])->name('blog-posts.comments');
    Route::put('/comments/{comment}/status', [CommentController::class, 'updateStatus'])->name('comments.update-status');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::get('/comments/{comment}', [CommentController::class, 'show'])->name('comments.show');

    // Reviews moderation
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::patch('/reviews/{review}/status', [ReviewController::class, 'updateStatus'])->name('reviews.status');
    Route::patch('/reviews/{reviewUuid}/status-uuid', [WebsiteReviewController::class, 'updateStatus'])->name('website.reviews.update-status');
    Route::patch('/reviews/{reviewUuid}/toggle-featured', [WebsiteReviewController::class, 'toggleFeatured'])->name('website.reviews.toggle-featured');
    Route::delete('/reviews/{reviewUuid}', [WebsiteReviewController::class, 'destroy'])->name('website.reviews.destroy');
});

/*
|--------------------------------------------------------------------------
| Lawyer (and Super Admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:lawyer|super_admin'])->group(function () {
    // Lawyer public profile management
    Route::get('lawyer/profile/edit', [LawyerProfileController::class, 'edit'])->name('lawyer.profile.edit');
    Route::put('lawyer/profile', [LawyerProfileController::class, 'update'])->name('lawyer.profile.update');
    Route::put('lawyer/profile/password', [LawyerProfileController::class, 'updatePassword'])->name('lawyer.profile.password');
    Route::get('lawyer/view', [LawyerProfileController::class, 'show'])->name('lawyer.profile.show');

    // Blog Posts Routes
    Route::resource('blog-posts', BlogPostController::class);

    // Education Routes
    Route::resource('educations', EducationController::class);

    // Experience Routes
    Route::resource('experiences', ExperienceController::class);
});

// Dashboard routes for lawyers
Route::middleware(['auth', 'role:lawyer'])->prefix('dashboard')->group(function () {
    Route::resource('videos', \App\Http\Controllers\VideoController::class);
    Route::resource('team-members', \App\Http\Controllers\TeamMemberController::class)->except(['show']);

    // Clients
    Route::resource('clients', \App\Http\Controllers\Lawyer\ClientController::class);

    // Cases
    Route::resource('cases', \App\Http\Controllers\Lawyer\CaseController::class)->parameters(['cases' => 'case']);
    Route::patch('cases/{case}/status', [\App\Http\Controllers\Lawyer\CaseController::class, 'updateStatus'])->name('cases.status');

    // Case documents
    Route::post('cases/{case}/documents', [\App\Http\Controllers\Lawyer\CaseController::class, 'storeDocument'])->name('cases.documents.store');
    Route::patch('cases/{case}/documents/{document}/visibility', [\App\Http\Controllers\Lawyer\CaseController::class, 'toggleDocumentVisibility'])->name('cases.documents.visibility');
    Route::delete('cases/{case}/documents/{document}', [\App\Http\Controllers\Lawyer\CaseController::class, 'destroyDocument'])->name('cases.documents.destroy');

    // Case notes
    Route::post('cases/{case}/notes', [\App\Http\Controllers\Lawyer\CaseController::class, 'storeNote'])->name('cases.notes.store');
    Route::delete('cases/{case}/notes/{note}', [\App\Http\Controllers\Lawyer\CaseController::class, 'destroyNote'])->name('cases.notes.destroy');

    // Case hearings
    Route::post('cases/{case}/hearings', [\App\Http\Controllers\Lawyer\CaseController::class, 'storeHearing'])->name('cases.hearings.store');
    Route::patch('cases/{case}/hearings/{hearing}', [\App\Http\Controllers\Lawyer\CaseController::class, 'updateHearing'])->name('cases.hearings.update');

    // Client reviews moderation (lawyer approves/rejects their own reviews)
    Route::get('reviews', [\App\Http\Controllers\Lawyer\ReviewController::class, 'index'])->name('lawyer.reviews.index');
    Route::patch('reviews/{review}/status', [\App\Http\Controllers\Lawyer\ReviewController::class, 'updateStatus'])->name('lawyer.reviews.status');
    Route::patch('reviews/{review}/feature', [\App\Http\Controllers\Lawyer\ReviewController::class, 'toggleFeatured'])->name('lawyer.reviews.feature');
    Route::delete('reviews/{review}', [\App\Http\Controllers\Lawyer\ReviewController::class, 'destroy'])->name('lawyer.reviews.destroy');

    // Data backup (Excel export)
    Route::get('backup/export', [\App\Http\Controllers\Lawyer\BackupController::class, 'export'])->name('backup.export');

    // Schedule / Calendar
    Route::get('schedule', [\App\Http\Controllers\Lawyer\ScheduleController::class, 'index'])->name('schedule.index');
    Route::get('schedule/events', [\App\Http\Controllers\Lawyer\ScheduleController::class, 'getEvents'])->name('schedule.events');
    Route::post('schedule', [\App\Http\Controllers\Lawyer\ScheduleController::class, 'store'])->name('schedule.store');
    Route::put('schedule/{schedule}', [\App\Http\Controllers\Lawyer\ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('schedule/{schedule}', [\App\Http\Controllers\Lawyer\ScheduleController::class, 'destroy'])->name('schedule.destroy');
});

/*
|--------------------------------------------------------------------------
| Client Portal
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Client\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/cases', [\App\Http\Controllers\Client\CaseController::class, 'index'])->name('cases.index');
    Route::get('/cases/{case}', [\App\Http\Controllers\Client\CaseController::class, 'show'])->name('cases.show');
    Route::get('/schedule', [\App\Http\Controllers\Client\ScheduleController::class, 'index'])->name('schedule');
});

require __DIR__ . '/auth.php';
