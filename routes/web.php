<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SetupPackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ProfileController;

// Auth routes
Route::get('/', [AuthController::class, 'index']);
Route::get('/choose-role', [AuthController::class, 'chooseRole'])->name('choose.role');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register.choose');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard routes (harus login)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'customerDashboard'])->name('dashboard.customer');
    Route::get('/dashboard/mitra', [DashboardController::class, 'mitraDashboard'])->name('dashboard.mitra');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/edit', [ProfileController::class, 'update'])->name('profile.update');

    // Mitra Setup Services CRUD
    Route::post('/admin/setup-services', [DashboardController::class, 'storeSetupService'])->name('admin.setup-services.store');
    Route::put('/admin/setup-services/{id}', [DashboardController::class, 'updateSetupService'])->name('admin.setup-services.update');
    Route::delete('/admin/setup-services/{id}', [DashboardController::class, 'destroySetupService'])->name('admin.setup-services.destroy');

    // Mitra Orders Management
    Route::post('/admin/orders/{id}/accept', [DashboardController::class, 'acceptOrder'])->name('admin.orders.accept');
    Route::post('/admin/orders/{id}/reject', [DashboardController::class, 'rejectOrder'])->name('admin.orders.reject');
    Route::post('/admin/orders/{id}/complete', [DashboardController::class, 'completeOrder'])->name('admin.orders.complete');
});

// Setup Packages routes
Route::get('/setup', [SetupPackageController::class, 'index'])->name('setup.index');
Route::get('/setup/{id}', [SetupPackageController::class, 'show'])->name('setup.show');

// Course routes
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{id}', [CourseController::class, 'show'])->name('courses.show');
Route::middleware('auth')->get('/my-courses', [CourseController::class, 'myCourses'])->name('courses.my');

// Payment routes
Route::middleware('auth')->group(function () {
    Route::get('/payment/product/{id}', [PaymentController::class, 'showProductPayment'])->name('payment.product');
    Route::post('/payment/product/{id}', [PaymentController::class, 'processProductPayment'])->name('payment.product.process');
    
    Route::get('/payment/setup/{id}', [PaymentController::class, 'showSetupPayment'])->name('payment.setup');
    Route::post('/payment/setup/{id}', [PaymentController::class, 'processSetupPayment'])->name('payment.setup.process');

    // QRIS Payment
    Route::get('/payment/qris/{type}/{id}', [PaymentController::class, 'showQris'])->name('payment.qris');
    Route::post('/payment/qris/process', [PaymentController::class, 'processQris'])->name('payment.qris.process');
});

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Order routes (harus login)
Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
});

// Admin routes
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('orders', OrderController::class);
});