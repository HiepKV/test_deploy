<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ManagerController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/{userId}', [UserController::class, 'show'])->name('show');
});



// Company Routes
Route::get('/companies', [CompanyController::class, 'index']);
Route::post('/companies', [CompanyController::class, 'store']);
Route::get('/companies/{id}', [CompanyController::class, 'show']);
// Route::put('/companies/{id}', [CompanyController::class, 'update']);
// Route::delete('/companies/{id}', [CompanyController::class, 'destroy']);

// Manager Routes
Route::get('/managers', [ManagerController::class, 'index']);
Route::post('/managers', [ManagerController::class, 'store']);