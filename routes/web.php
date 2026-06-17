<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyTaxController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'doRegister'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::resource('users', UserController::class)->except(['show']);

// Property Tax Bill Routes
Route::get('/property-tax/upload',
            [PropertyTaxController::class,'uploadForm'])
            ->name('property-tax.upload');

        Route::post('/property-tax/import',
            [PropertyTaxController::class,'import'])
            ->name('property-tax.import');

        Route::get('/property-tax/bills',
            [PropertyTaxController::class,'bills'])
            ->name('property-tax.list');

        Route::get('/property-tax/bill/{id}',
            [PropertyTaxController::class,'show'])
            ->name('property-tax.bill.view');


});

