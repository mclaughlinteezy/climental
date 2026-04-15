<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

// Phase 4 - Mental Health Module
Route::middleware('auth')->prefix('mental-health')->name('mental-health.')->group(function () {
    Route::get('/mood', [\App\Http\Controllers\MentalHealthController::class, 'index'])->name('index'); // Alias for easier discovery
    Route::post('/mood', [\App\Http\Controllers\MentalHealthController::class, 'storeMood'])->name('mood.store');
    Route::get('/emergency', [\App\Http\Controllers\MentalHealthController::class, 'emergency'])->name('emergency');
    Route::post('/clubs/{club}/join', [\App\Http\Controllers\MentalHealthController::class, 'joinClub'])->name('clubs.join');
    
    // Support Groups
    Route::get('/groups', [\App\Http\Controllers\SupportGroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/{group}', [\App\Http\Controllers\SupportGroupController::class, 'show'])->name('groups.show');
    Route::post('/groups/{group}/posts', [\App\Http\Controllers\SupportGroupController::class, 'storePost'])->name('groups.posts.store');
    Route::post('/posts/{post}/comments', [\App\Http\Controllers\SupportGroupController::class, 'storeComment'])->name('posts.comments.store');
});

// Phase 5 - Climate Module
Route::middleware('auth')->prefix('climate')->name('climate.')->group(function () {
    Route::get('/', [\App\Http\Controllers\ClimateController::class, 'index'])->name('index');
    Route::post('/clubs/{club}/join', [\App\Http\Controllers\ClimateController::class, 'joinClub'])->name('clubs.join');
});

// Phase 6 - Events Module
Route::middleware('auth')->prefix('events')->name('events.')->group(function () {
    Route::get('/', [\App\Http\Controllers\EventController::class, 'index'])->name('index');
    Route::get('/{event}', [\App\Http\Controllers\EventController::class, 'show'])->name('show');
    Route::post('/{event}/rsvp', [\App\Http\Controllers\EventController::class, 'rsvp'])->name('rsvp');
});

// Phase 7 - Map System
Route::middleware('auth')->prefix('map')->name('map.')->group(function () {
    Route::get('/', [\App\Http\Controllers\MapController::class, 'index'])->name('index');
});

// Phase 8 - Community Module
Route::middleware('auth')->group(function () {
    Route::get('/community', [\App\Http\Controllers\CommunityController::class, 'index'])->name('community.index');
    Route::post('/community/posts', [\App\Http\Controllers\CommunityController::class, 'storePost'])->name('community.posts.store');
    Route::get('/community/posts/{post}/image', [\App\Http\Controllers\CommunityController::class, 'image'])->name('community.posts.image');
    Route::post('/community/posts/{post}/comments', [\App\Http\Controllers\CommunityController::class, 'storeComment'])->name('community.posts.comments.store');
    Route::post('/community/posts/{post}/like', [\App\Http\Controllers\CommunityController::class, 'toggleLike'])->name('community.posts.like');
    Route::post('/community/posts/{post}/repost', [\App\Http\Controllers\CommunityController::class, 'repost'])->name('community.posts.repost');
    Route::put('/community/posts/{post}', [\App\Http\Controllers\CommunityController::class, 'updatePost'])->name('community.posts.update');
    Route::get('/community/moderate', [\App\Http\Controllers\CommunityController::class, 'moderate'])->name('community.moderate');
    Route::delete('/community/posts/{post}', [\App\Http\Controllers\CommunityController::class, 'deletePost'])->name('community.posts.destroy');
    
    // Reports system
    Route::post('/reports', [\App\Http\Controllers\ReportController::class, 'store'])->name('reports.store');
    Route::post('/reports/{report}/resolve', [\App\Http\Controllers\ReportController::class, 'resolve'])->name('reports.resolve');
});

// Phase 9 - Gamification
Route::middleware('auth')->prefix('gamification')->name('gamification.')->group(function () {
    Route::get('/', [\App\Http\Controllers\GamificationController::class, 'index'])->name('index');
});

// Phase 10 - Admin Panel (admin role required)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

    // User CRUD
    Route::get('/users', [\App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\Admin\AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\Admin\AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('users.destroy');

    // Events CRUD
    Route::get('/events', [\App\Http\Controllers\Admin\AdminEventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [\App\Http\Controllers\Admin\AdminEventController::class, 'create'])->name('events.create');
    Route::post('/events', [\App\Http\Controllers\Admin\AdminEventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}/edit', [\App\Http\Controllers\Admin\AdminEventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [\App\Http\Controllers\Admin\AdminEventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [\App\Http\Controllers\Admin\AdminEventController::class, 'destroy'])->name('events.destroy');

    // Organizations CRUD
    Route::get('/organizations', [\App\Http\Controllers\Admin\AdminOrganizationController::class, 'index'])->name('organizations.index');
    Route::get('/organizations/create', [\App\Http\Controllers\Admin\AdminOrganizationController::class, 'create'])->name('organizations.create');
    Route::post('/organizations', [\App\Http\Controllers\Admin\AdminOrganizationController::class, 'store'])->name('organizations.store');
    Route::get('/organizations/{organization}/edit', [\App\Http\Controllers\Admin\AdminOrganizationController::class, 'edit'])->name('organizations.edit');
    Route::put('/organizations/{organization}', [\App\Http\Controllers\Admin\AdminOrganizationController::class, 'update'])->name('organizations.update');
    Route::delete('/organizations/{organization}', [\App\Http\Controllers\Admin\AdminOrganizationController::class, 'destroy'])->name('organizations.destroy');

    // Map Places CRUD
    Route::get('/places', [\App\Http\Controllers\Admin\AdminPlaceController::class, 'index'])->name('places.index');
    Route::get('/places/create', [\App\Http\Controllers\Admin\AdminPlaceController::class, 'create'])->name('places.create');
    Route::post('/places', [\App\Http\Controllers\Admin\AdminPlaceController::class, 'store'])->name('places.store');
    Route::get('/places/{place}/edit', [\App\Http\Controllers\Admin\AdminPlaceController::class, 'edit'])->name('places.edit');
    Route::put('/places/{place}', [\App\Http\Controllers\Admin\AdminPlaceController::class, 'update'])->name('places.update');
    Route::delete('/places/{place}', [\App\Http\Controllers\Admin\AdminPlaceController::class, 'destroy'])->name('places.destroy');

    // Recycling Points CRUD
    Route::get('/recycling-points', [\App\Http\Controllers\Admin\AdminRecyclingPointController::class, 'index'])->name('recycling-points.index');
    Route::get('/recycling-points/create', [\App\Http\Controllers\Admin\AdminRecyclingPointController::class, 'create'])->name('recycling-points.create');
    Route::post('/recycling-points', [\App\Http\Controllers\Admin\AdminRecyclingPointController::class, 'store'])->name('recycling-points.store');
    Route::get('/recycling-points/{recyclingPoint}/edit', [\App\Http\Controllers\Admin\AdminRecyclingPointController::class, 'edit'])->name('recycling-points.edit');
    Route::put('/recycling-points/{recyclingPoint}', [\App\Http\Controllers\Admin\AdminRecyclingPointController::class, 'update'])->name('recycling-points.update');
    Route::delete('/recycling-points/{recyclingPoint}', [\App\Http\Controllers\Admin\AdminRecyclingPointController::class, 'destroy'])->name('recycling-points.destroy');

    // System Settings
    Route::get('/settings', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
