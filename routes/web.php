<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('register',[RegistrationController::class,'loadRegistrationPage']);
Route::get('forget_password',[RegistrationController::class,'loadForgetPasswordPage']);
Route::post('request_password',[RegistrationController::class,'request_password']);
Route::post('verify_otp',[RegistrationController::class,'verify_otp']);
