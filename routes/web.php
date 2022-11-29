<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistrationController;
use App\Notifications\SendNotification;
use GuzzleHttp\Psr7\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

//use App\Http\Middleware\UserAuthentication;

use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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



// Route::get('/', function () {
//     return view('welcome');
// });

// // Route::get('/', function () {
// //     //
// // })->middleware('web');

// // RegistrationController




// Route::get('register',[RegistrationController::class,'loadRegistrationPage']);


// //Route::post('user_page',[RegistrationController::class,'checkAuth']);
// // Route::get('/user_page', function () {
// //     if (auth()->user()->role === 'employer') {
// //         return view('admin_page');
// //     } else {
// //         return view('user');
// //     }
// // })->name('user_authentication');

// // Route::post('user_page', function () {
// //     //
// // })->middleware('user_authentication');

// Route::get('forget_password',[RegistrationController::class,'loadForgetPasswordPage']);
// Route::post('request_password',[RegistrationController::class,'requestPassword']);

// Route::post('verify_otp',[RegistrationController::class,'verifyOtp']);
// Route::post('change_password',[RegistrationController::class,'changePassword']);

// Route::post('abc',[RegistrationController::class,'getNewPassword']);

// //AdminController
// Route::get('user_details',[AdminController::class,'loadUserDetails']);
// Route::post('edit_user',[AdminController::class,'editUserDetails']);

// Route::get('/delete_user',[AdminController::class,'deleteUserDetails']);
// Route::get('/admin_page',[AdminController::class,'loadAdminDashboard']);
// Route::get('/user_profile',[AdminController::class,'loadUserProfilePage']);
// Route::post('/status_change',[AdminController::class,'userstatus_inactive']);

// Route::post('/image_upload', [ImageUploadController::class, 'imageUpload']);
// Route::post('/banner_upload', [ImageUploadController::class, 'imageUpload']);

// Route::get('/upload_gallery', [ImageUploadController::class, 'fetchGalleries']);

// Route::get('/load_images', [ImageUploadController::class, 'loadImages']);
// Route::post('/add_new_gallery', [ImageUploadController::class, 'loadNewGallery']);
// Route::post('/delete_photos', [ImageUploadController::class, 'delete_photos']);
// Route::post('/remove_pic', [ImageUploadController::class, 'remove_pic']);
// Route::post('/set_profile_pic', [ImageUploadController::class, 'set_profile_pic']);
// Route::get('/dashboard_page', [DashboardController::class, 'dashboard_page']);


Route::group(['middleware'=>['web','checkAdmin']],function(){
    Route::get('admindashboard',[RegistrationController::class,'loadAdminPage']);
});
Route::group(['middleware'=>['web','checkUser']],function(){
    Route::get('dashboard_page',[RegistrationController::class,'loadUserPage']);
});

Auth::routes();
Route::get('/', function () {
    return view('welcome');
});
// Route::get('/', [RegistrationController::class, 'loadLogin']);
Route::get('logout', [RegistrationController::class, 'logOut']);
Route::post('user_page',[RegistrationController::class,'checkAuth']);


Route::get('register',[RegistrationController::class,'loadRegistrationPage']);
Route::get('forget_password',[RegistrationController::class,'loadForgetPasswordPage']);
Route::post('request_password',[RegistrationController::class,'requestPassword']);


Route::post('verify_otp',[RegistrationController::class,'verifyOtp']);
Route::post('change_password',[RegistrationController::class,'changePassword']);

Route::post('abc',[RegistrationController::class,'getNewPassword']);
Route::get('/admin_page',[RegistrationController::class,'loadAdminPage']);
//AdminController
Route::get('user_details',[AdminController::class,'loadUserDetails']);
Route::post('edit_user',[AdminController::class,'editUserDetails']);

Route::get('/delete_user',[AdminController::class,'deleteUserDetails']);
//Route::get('/dashboard',[AdminController::class,'loadAdminDashboard']);
Route::get('/user_profile',[AdminController::class,'loadUserProfilePage']);
Route::post('/status_change',[AdminController::class,'userstatus_inactive']);

Route::post('edit_user_details',[ImageUploadController::class,'editUser']);
Route::post('/image_upload', [ImageUploadController::class, 'imageUpload']);

Route::post('/banner_upload', [ImageUploadController::class, 'imageUpload']);

Route::get('/upload_gallery', [ImageUploadController::class, 'fetchGalleries']);

Route::get('/load_images', [ImageUploadController::class, 'loadImages']);


Route::post('/add_new_gallery', [ImageUploadController::class, 'loadNewGallery']);
Route::post('/delete_photos', [ImageUploadController::class, 'delete_photos']);
Route::post('/remove_pic', [ImageUploadController::class, 'remove_pic']);
Route::post('/set_profile_pic', [ImageUploadController::class, 'set_profile_pic']);
Route::get('/dashboard_page', [DashboardController::class, 'dashboard_page']);
Route::get('/admindashboard', [DashboardController::class, 'dashboard_page']);

Route::post('/send_to_slack', [SendNotification::class, 'toSlack']);

Route::get('/send_to_wp', [ImageUploadController::class, 'send']);

Route::post('/message', function(Request $request) {
    // TODO: validate incoming params first!
 
    $url = "https://messages-sandbox.nexmo.com/v0.1/messages";
    $params = ["to" => ["type" => "whatsapp", "number" =>"6371668018"],
        "from" => ["type" => "whatsapp", "number" => "14157386170"],
        "message" => [
            "content" => [
                "type" => "text",
                "text" => "Hello from Vonage and Laravel :) Please reply to this message with a number between 1 and 100"
            ]
        ]
    ];
    $headers = ["Authorization" => "Basic " . base64_encode(env('NEXMO_API_KEY') . ":" . env('NEXMO_API_SECRET'))];
 
    $client = new \GuzzleHttp\Client();
    $response = $client->request('POST', $url, ["headers" => $headers, "json" => $params]);
    $data = $response->getBody();
    
 
    return view('thanks');
});