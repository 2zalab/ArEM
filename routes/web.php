<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ValidationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/help', [HomeController::class, 'help'])->name('help');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Search routes
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/advanced', [SearchController::class, 'advanced'])->name('search.advanced');

// Document routes - IMPORTANT: specific routes BEFORE parameterized routes
Route::get('/documents', [DocumentController::class, 'index'])->name('documents.index');
Route::get('/documents/browse', [DocumentController::class, 'browse'])->name('documents.browse');
Route::get('/documents/create', [DocumentController::class, 'create'])->middleware(['auth', 'verified'])->name('documents.create');
Route::post('/documents', [DocumentController::class, 'store'])->middleware(['auth', 'verified'])->name('documents.store');
Route::get('/documents/{aremDocId}/download', [DocumentController::class, 'download'])->name('documents.download');
Route::get('/documents/{aremDocId}/edit', [DocumentController::class, 'edit'])->middleware(['auth', 'verified'])->name('documents.edit');
Route::patch('/documents/{aremDocId}', [DocumentController::class, 'update'])->middleware(['auth', 'verified'])->name('documents.update');
Route::delete('/documents/{aremDocId}', [DocumentController::class, 'destroy'])->middleware(['auth', 'verified'])->name('documents.destroy');
Route::get('/documents/{aremDocId}', [DocumentController::class, 'show'])->name('documents.show');

// Authenticated routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard - redirect to profile documents
    Route::get('/dashboard', function () {
        return redirect()->route('profile.documents');
    })->name('dashboard');

    // Profile - redirect /profile to /profile/documents
    Route::get('/profile', function () {
        return redirect()->route('profile.documents');
    })->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/documents', [ProfileController::class, 'documents'])->name('profile.documents');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});

// Validation routes (moderators and admins only)
Route::middleware(['auth', 'verified'])->prefix('validation')->name('validation.')->group(function () {
    Route::get('/', [ValidationController::class, 'index'])->name('index');
    Route::get('/{aremDocId}', [ValidationController::class, 'show'])->name('show');
    Route::post('/{aremDocId}/approve', [ValidationController::class, 'approve'])->name('approve');
    Route::post('/{aremDocId}/reject', [ValidationController::class, 'reject'])->name('reject');
    Route::post('/{aremDocId}/request-revision', [ValidationController::class, 'requestRevision'])->name('requestRevision');
});

// Admin routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('index');

    // User management
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::get('/users/{id}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::patch('/users/{id}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('users.delete');

    // Department management
    Route::get('/departments', [AdminController::class, 'departments'])->name('departments');
    Route::post('/departments', [AdminController::class, 'storeDepartment'])->name('departments.store');
    Route::patch('/departments/{id}', [AdminController::class, 'updateDepartment'])->name('departments.update');
    Route::delete('/departments/{id}', [AdminController::class, 'deleteDepartment'])->name('departments.delete');

    // Document type management
    Route::get('/document-types', [AdminController::class, 'documentTypes'])->name('documentTypes');
    Route::post('/document-types', [AdminController::class, 'storeDocumentType'])->name('documentTypes.store');
    Route::patch('/document-types/{id}', [AdminController::class, 'updateDocumentType'])->name('documentTypes.update');
    Route::delete('/document-types/{id}', [AdminController::class, 'deleteDocumentType'])->name('documentTypes.delete');

    // Statistics
    Route::get('/statistics', [AdminController::class, 'statistics'])->name('statistics');
});

require __DIR__.'/auth.php';

// Debug routes (à supprimer en production)
if (file_exists(__DIR__.'/debug.php')) {
    require __DIR__.'/debug.php';
}
