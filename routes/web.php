<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\QuoteController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// ============ ROUTES PUBLIQUES ============

// Page d'accueil avec les actualités
Route::get('/', [FrontController::class, 'index'])->name('home');

// Page à propos
Route::get('/a-propos', function () {
    return view('apropos');
})->name('apropos');

// Page contact
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Formulaire de contact (public)
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Page actualités
Route::get('/actualites', [FrontController::class, 'actualites'])->name('actualites');

// Détail d'une actualité
Route::get('/actualites/{slug}', [FrontController::class, 'showActualite'])->name('actualite.show');

// ============ ROUTES D'AUTHENTIFICATION ============

Route::get('/admin/login', [AuthController::class, "loginForm"])->name("loginForm");
Route::post('/admin/login', [AuthController::class, "login"])->name("login");
Route::post('/admin/logout', [AuthController::class, "logout"])->name("logout");
Route::get('/admin/otp-code', [AuthController::class, "showOtpForm"])->name("otp.verify.form");
Route::post('/admin/otp-code-verify', [AuthController::class, "verifyOtp"])->name("otpCode-verify");
Route::post('/admin/otp-code-resend', [AuthController::class, "resendOtp"])->name("otpCode-resend");

// ============ ROUTES ADMIN PROTÉGÉES ============

Route::prefix('admin')->name('admins.')->middleware(['admin.auth'])->group(function () {
    
    Route::get('/dashboard', [AuthController::class, "dashboard"])->name('dashboard');
    
    Route::resource('news', NewsController::class);
    Route::post('news/{id}/toggle-publish', [NewsController::class, 'togglePublish'])->name('news.toggle-publish');
    
    Route::resource('quotes', QuoteController::class);
    Route::put('quotes/{id}/change-status', [QuoteController::class, 'changeStatus'])->name('quotes.change-status');
    Route::get('quotes/{id}/export-pdf', [QuoteController::class, 'exportPdf'])->name('quotes.export-pdf');
    
   // Contacts
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{id}', [ContactController::class, 'show'])->name('contacts.show');
    Route::post('contacts/{id}/mark-as-read', [ContactController::class, 'markAsRead'])->name('contacts.mark-as-read');
    Route::post('contacts/{id}/mark-as-unread', [ContactController::class, 'markAsUnread'])->name('contacts.mark-as-unread');
    Route::post('contacts/mark-all-read', [ContactController::class, 'markAllAsRead'])->name('contacts.mark-all-read');
    Route::delete('contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');

});