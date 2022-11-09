<?php

use App\Http\Controllers\AdminController;
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
// RegistrationController

Route::get('register',[RegistrationController::class,'loadRegistrationPage']);

Route::post('user_page',[RegistrationController::class,'checkAuth']);

Route::get('forget_password',[RegistrationController::class,'loadForgetPasswordPage']);
Route::post('request_password',[RegistrationController::class,'requestPassword']);

Route::post('verify_otp',[RegistrationController::class,'verifyOtp']);
Route::post('change_password',[RegistrationController::class,'changePassword']);

Route::post('abc',[RegistrationController::class,'getNewPassword']);

//AdminController
Route::get('user_details',[AdminController::class,'loadUserDetails']);