<?php

namespace App\Http\Controllers;

use App\Models\UserDetailsModel;
use Illuminate\Http\Request;
use PharIo\Manifest\AuthorCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtp;


class RegistrationController extends Controller
{
    //
    function loadRegistrationPage(){
        $user_details= UserDetailsModel::all();
        return $user_details;
        //return view('register');
    }
    function loadForgetPasswordPage(){
        // $user_details= UserDetailsModel::all();
        // return $user_details;
        return view('forget_password');
    }
    function formData(Request $request){
        // print_r($request->input());
        $user_details             = new UserDetailsModel;
        $user_details->username   = $request->user_name;
        $hashedPassword           = Hash::make( $request->password);
        $user_details->password   = $hashedPassword;
        
        //Hash::make('secret');
        $user_details->email      = $request->email;
        $user_details->address    = $request->addres;
        $user_details->phone_no   = $request->phnno;
        $user_details->user_type  = 1;
        $user_details->active     = 1;
        // $user_details->created_at = now();
        // $user_details->updated_at = now();
        $user_details->save();
    }
    public function checkAuth(Request $request)
    {
        
        $user=UserDetailsModel::where('email',$request->mail_id)->first();
        if(!$user || !Hash::check($request->passsword,$user->password))
        {
            return 'user not found';
        }
        else{
            return view('user_profile');
        }
    }
    public function request_password(Request $request)
    {
        $otp = rand(100000,999999);
        Log::info("otp = ".$otp);
        $user = UserDetailsModel::where('email','=',$request->otp_email)->update(['otp' => $otp]);

        if($user){

        $mail_details = [
            //'subject' => 'Testing Application OTP',
            'otp' => $otp
        ];

        Mail::to($request->otp_email)->send(new SendOtp($mail_details));
        
            return view("otp_front");
        }
        else{
            return 'Invalid';
        }
    }
    public function verify_otp(Request $request)
    {
        echo $request;
    }
}
