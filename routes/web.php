<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\SubscriptionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

// Improved Migration & Seeding for Vercel (Split to prevent timeouts)
Route::group(['prefix' => 'v-db'], function () {
    // 1. Check Status & Diagnostic
    Route::get('/status', function () {
        $dbConfig = config('database.connections.pgsql');
        echo "<h1>NutriBox Migration Diagnostic (Supabase)</h1>";
        echo "<strong>Active Host:</strong> " . ($dbConfig['host'] ?? (isset($dbConfig['url']) ? parse_url($dbConfig['url'], PHP_URL_HOST) : 'not set')) . "<br>";
        echo "<hr>";
        
        try {
            Artisan::call('migrate:status');
            return "<pre>" . Artisan::output() . "</pre>";
        } catch (\Throwable $e) {
            return "<h1>Connection Error:</h1><pre>" . $e->getMessage() . "</pre>";
        }
    });

    // 2. Run Migrations Only
    Route::get('/migrate', function () {
        try {
            Artisan::call('migrate', ['--force' => true]);
            return "<h1>Migrations Success</h1><pre>" . Artisan::output() . "</pre>";
        } catch (\Exception $e) {
            return "<h1>Migrations Failed</h1><pre>" . $e->getMessage() . "</pre>";
        }
    });

    // 3. Run Seeders Only
    Route::get('/seed', function () {
        try {
            Artisan::call('db:seed', ['--force' => true]);
            return "<h1>Seeding Success</h1><pre>" . Artisan::output() . "</pre>";
        } catch (\Exception $e) {
            return "<h1>Seeding Failed</h1><pre>" . $e->getMessage() . "</pre>";
        }
    });
});

// Legacy redirect for convenience
Route::get('/v-migrate', function () {
    return redirect('/v-db/migrate');
});

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/menu', [MenuController::class, 'index'])->name('menu');
Route::get('/about', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// User Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/order', [OrderController::class, 'create'])->name('order.create');
    Route::post('/order', [OrderController::class, 'store'])->name('order.store');
    
    // Payment Simulation
    Route::get('/payment/{subscription}', [\App\Http\Controllers\PaymentController::class, 'show'])->name('payment.show');
    Route::post('/payment/{subscription}', [\App\Http\Controllers\PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/{subscription}/success', [\App\Http\Controllers\PaymentController::class, 'success'])->name('payment.success');
    
    // Invoices
    Route::get('/invoice/{subscription}', [\App\Http\Controllers\InvoiceController::class, 'show'])->name('invoice.show');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Subscription Detail
    Route::get('/subscription/{subscription}', [DashboardController::class, 'showSubscription'])->name('subscription.show');

    // Selection (Add to Cart for weekly menu)
    Route::post('/selection', [\App\Http\Controllers\SelectionController::class, 'store'])->name('selection.store');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('menu', \App\Http\Controllers\Admin\MenuController::class);
    Route::resource('plan', \App\Http\Controllers\Admin\PlanController::class);
});

// API Routes
Route::middleware('auth')->prefix('api')->group(function () {
    Route::post('/subscription/pause', [SubscriptionController::class, 'pause'])->name('api.subscription.pause');
});
