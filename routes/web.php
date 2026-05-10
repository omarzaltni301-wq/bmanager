<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BudgetTipsController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

// ── Public Routes ──
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/budget-tips', [BudgetTipsController::class, 'index'])->name('budget-tips');
Route::get('/contact', [FeedbackController::class, 'index'])->name('contact');

// ── Auth Routes (guest only) ──
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// ── Authenticated Routes ──
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/calculator', [CalculatorController::class, 'index'])->name('calculator');

    // Feedback
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

    // Calculator CRUD (JSON API)
    Route::post('/incomes', [CalculatorController::class, 'storeIncome'])->name('incomes.store');
    Route::put('/incomes/{id}', [CalculatorController::class, 'updateIncome'])->name('incomes.update');
    Route::delete('/incomes/{id}', [CalculatorController::class, 'deleteIncome'])->name('incomes.destroy');

    Route::post('/expenses', [CalculatorController::class, 'storeExpense'])->name('expenses.store');
    Route::put('/expenses/{id}', [CalculatorController::class, 'updateExpense'])->name('expenses.update');
    Route::delete('/expenses/{id}', [CalculatorController::class, 'deleteExpense'])->name('expenses.destroy');

    Route::post('/savings', [CalculatorController::class, 'storeSaving'])->name('savings.store');
    Route::put('/savings/{id}', [CalculatorController::class, 'updateSaving'])->name('savings.update');
    Route::delete('/savings/{id}', [CalculatorController::class, 'deleteSaving'])->name('savings.destroy');
<<<<<<< HEAD
=======

    // Chatbot
    Route::post('/chatbot/message', [\App\Http\Controllers\ChatbotController::class, 'message'])->name('chatbot.message');
>>>>>>> origin/main
});

// ── Admin Routes ──
Route::middleware(['auth', \App\Http\Middleware\IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [\App\Http\Controllers\AdminController::class, 'users'])->name('users');
    Route::get('/feedbacks', [\App\Http\Controllers\AdminController::class, 'feedbacks'])->name('feedbacks');
    
    // Manage Prices
    Route::get('/prices', [\App\Http\Controllers\AdminController::class, 'prices'])->name('prices');
    Route::post('/prices', [\App\Http\Controllers\AdminController::class, 'storePrice'])->name('prices.store');
    Route::put('/prices/{id}', [\App\Http\Controllers\AdminController::class, 'updatePrice'])->name('prices.update');
    Route::delete('/prices/{id}', [\App\Http\Controllers\AdminController::class, 'deletePrice'])->name('prices.destroy');
});
