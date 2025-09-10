<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\SurveyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MailTestController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\RecipientController;

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

// Account Routes
Route::get('/accounts', [AccountController::class, 'index']);
Route::post('/accounts', [AccountController::class, 'store']);

// Survey Routes
Route::get('/surveys', [SurveyController::class, 'index']);
Route::get('/surveys/{id}', [SurveyController::class, 'getById']);
Route::post('/surveys', [SurveyController::class, 'store']);


// Test mail
Route::get('/send-mail', [MailTestController::class, 'sendTest']);
Route::post('/import-excel', [ImportController::class, 'checkExcel']); // send mail with keyword, prefectures
Route::post('/import-excel-result', [ImportController::class, 'previewImport']);

//Export excel
Route::get('/export-excel', [ImportController::class, 'export']);

//recipients
Route::get('/recipients/{id}', [RecipientController::class, 'getRecipientById']);
Route::post('/recipients', [RecipientController::class, 'store']);

//auth
Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::middleware('auth:api')->post('/logout', [\App\Http\Controllers\Auth\AuthController::class, 'logout']);
