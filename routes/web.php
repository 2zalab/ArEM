<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\AdminController;

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/help', [HomeController::class, 'help'])->name('help');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Documents publics
Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/documents/browse', [DocumentController::class, 'browse'])->name('documents.browse');
Route::get('/documents/{aremDocId}', [DocumentController::class, 'show'])->name('documents.show');
Route::get('/documents/{aremDocId}/download', [DocumentController::class, 'download'])->name('documents.download');

// Recherche
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/advanced', [SearchController::class, 'advanced'])->name('search.advanced');

// Routes authentifiées
Route::middleware(['auth'])->group(function () {
    // Dépôt de documents
    Route::get('/documents/create', [DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{aremDocId}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
    Route::put('/documents/{aremDocId}', [DocumentController::class, 'update'])->name('documents.update');
    Route::delete('/documents/{aremDocId}', [DocumentController::class, 'destroy'])->name('documents.destroy');

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/documents', [ProfileController::class, 'documents'])->name('profile.documents');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
});

// Routes de validation (admin et modérateurs)
Route::middleware(['auth'])->prefix('validation')->name('validation.')->group(function () {
    Route::get('/', [ValidationController::class, 'index'])->name('index');
    Route::get('/{aremDocId}', [ValidationController::class, 'show'])->name('show');
    Route::post('/{aremDocId}/approve', [ValidationController::class, 'approve'])->name('approve');
    Route::post('/{aremDocId}/reject', [ValidationController::class, 'reject'])->name('reject');
    Route::post('/{aremDocId}/request-revision', [ValidationController::class, 'requestRevision'])->name('request-revision');
});

// Routes d'administration
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/departments', [AdminController::class, 'departments'])->name('departments');
    Route::get('/document-types', [AdminController::class, 'documentTypes'])->name('document-types');
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
});
