<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PropertyTaxController;
use App\Http\Controllers\UserBlockAssignmentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'doLogin'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'doRegister'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/assigned-blocks', [DashboardController::class, 'assignedBlocksPage'])->name('assigned-blocks');

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('users/{user}/assign-blocks', [UserController::class, 'assignBlocks'])->name('users.assign-blocks');
    Route::post('users/{user}/assign-blocks', [UserController::class, 'storeBlocks'])->name('users.store-blocks');
    Route::get('user-block-assignments', [UserBlockAssignmentController::class, 'index'])->name('user-block-assignments.index');
    Route::post('user-block-assignments', [UserBlockAssignmentController::class, 'store'])->name('user-block-assignments.store');
    Route::resource('users', UserController::class)->except(['show']);
    Route::resource('blocks', BlockController::class)->except(['show']);

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

