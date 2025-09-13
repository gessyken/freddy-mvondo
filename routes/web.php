<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CivilActController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/information', [PublicController::class, 'information'])->name('public.information');
Route::get('/contact', [PublicController::class, 'contact'])->name('public.contact');
Route::get('/faq', [PublicController::class, 'faq'])->name('public.faq');
Route::get('/verify', [PublicController::class, 'verifyAct'])->name('public.verify');
Route::get('/verify/{reference_number}', [PublicController::class, 'verifyAct'])->name('public.verify-act');
Route::get('/download/{civilAct}', [PublicController::class, 'downloadAct'])->name('public.download-act');

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Civil Acts routes
    Route::resource('civil-acts', CivilActController::class);
    Route::post('civil-acts/{civilAct}/submit', [CivilActController::class, 'submit'])->name('civil-acts.submit');
    
    // Document routes
    Route::post('civil-acts/{civilAct}/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('civil-acts/{civilAct}/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::delete('civil-acts/{civilAct}/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    Route::post('civil-acts/{civilAct}/documents/{document}/validate', [DocumentController::class, 'validate'])->name('documents.validate');
    
    // Payment routes
    Route::get('civil-acts/{civilAct}/payment', [PaymentController::class, 'create'])->name('payments.create');
    Route::post('civil-acts/{civilAct}/payment', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('payments/{payment}/callback', [PaymentController::class, 'callback'])->name('payments.callback');
    
    // Message routes
    Route::post('civil-acts/{civilAct}/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::post('messages/{message}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
    Route::get('civil-acts/{civilAct}/messages', [MessageController::class, 'getMessages'])->name('messages.get');
    Route::get('messages/unread-count', [MessageController::class, 'getUnreadCount'])->name('messages.unread-count');
    
    // Agent routes
    Route::middleware(['role:agent,admin'])->group(function () {
        Route::get('/agent/dashboard', [AgentController::class, 'dashboard'])->name('agent.dashboard');
        Route::get('/agent/pending-review', [AgentController::class, 'pendingReview'])->name('agent.pending-review');
        Route::post('civil-acts/{civilAct}/validate', [AgentController::class, 'validate'])->name('agent.validate');
        Route::post('civil-acts/{civilAct}/request-documents', [AgentController::class, 'requestDocuments'])->name('agent.request-documents');
    });
    
    // Admin routes
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/admin/civil-acts', [AdminController::class, 'civilActs'])->name('admin.civil-acts');
        
        // User management routes
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/admin/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
        Route::get('/admin/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::post('/admin/users/{user}/toggle-status', [AdminController::class, 'toggleUserStatus'])->name('admin.users.toggle-status');
        
        Route::get('/admin/configuration', [AdminController::class, 'configuration'])->name('admin.configuration');
        Route::post('/admin/configuration', [AdminController::class, 'updateConfiguration'])->name('admin.configuration.update');
        Route::get('/admin/reports', [AdminController::class, 'reports'])->name('admin.reports');
        Route::get('/admin/reports/export', [AdminController::class, 'exportReports'])->name('admin.reports.export');
    });
});

// Dashboard redirect based on user role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->isAgent()) {
        return redirect()->route('agent.dashboard');
    } else {
        return redirect()->route('civil-acts.index');
    }
})->middleware('auth')->name('dashboard');