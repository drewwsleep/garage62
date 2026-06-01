<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/cars', [PageController::class, 'cars'])->name('cars.page');
Route::get('/login', [PageController::class, 'login'])->name('login.page');
Route::get('/register', [PageController::class, 'register'])->name('register.page');
Route::get('/order', [PageController::class, 'order'])->name('order.page');
Route::get('/make-order', [PageController::class, 'makeOrder'])->name('make-order.page');

Route::get('/api/cars', [CarController::class, 'index'])->name('cars.index');
Route::post('/api/auth/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/api/auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::get('/api/auth/me', [AuthController::class, 'me'])->name('auth.me');
Route::post('/api/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::match(['get', 'post'], '/api/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/api/orders/create', [OrderController::class, 'create'])->name('orders.create');
Route::match(['get', 'post'], '/api/admin/cars', [AdminController::class, 'cars'])->name('admin.cars');
Route::match(['get', 'post'], '/api/admin/users', [AdminController::class, 'users'])->name('admin.users');
