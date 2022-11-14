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
        // $user_details= UserDetailsModel::all();
        // return $user_details;
        return view('register');
    }
    function loadForgetPasswordPage(){
        // $user_details= UserDetailsModel::all();
        // return $user_details;
        return view('forget_password');
    }
    function formData(Request $request){
        //print_r($request->input());
        //$output = array('dbStatus'=>'','dbMessage'=>'');
        $user_details             = new UserDetailsModel;
        $user_details->username   = $request->user_name;
        $hashedPassword           = Hash::make( $request->password);
        $user_details->password   = $hashedPassword;
        
        //Hash::make('secret');
        $user_details->email      = $request->email;
        $user_details->address    = $request->addres;
        $user_details->phone_no   = $request->phnno;
        $user_details->user_type  = 2;
        $user_details->active     = 1;
        // $user_details->created_at = now();
        // $user_details->updated_at = now();
        $user_details->save();
        // if($register)
        //  {
        //      $output['dbStatus']  = 'SUCCESS';
        //      $output['dbMessage'] = 'User Registered.';
        //  }
        //  else{
        //      $output['dbStatus']  = 'FAILURE';
        //      $output['dbMessage'] = 'OOPS! Someting Went Wrong in delete Operation.';
        //  }
        //  return response()->json($output); 
    }
    public function checkAuth(Request $request)
    {
       
        $user=UserDetailsModel::where('email',$request->mail_id)->first();

        session()-> put('login_id',$user->id);

        if(!$user || !Hash::check($request->passsword,$user->password))
        {
            return view('user_not_found');
        }
        else{
            if($user->user_type==1)
            {
                return view('admin_page');
            }
            else{
                return view('user_profile');
            }
            
        }
    }
    public function requestPassword(Request $request)
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

            session()-> put('mail',$request->otp_email);
        
            return view("otp_front");
        }
        else{
            return 'Invalid';
        }

    }
    public function verifyOtp(Request $request)
    {
        $otp          = $request->otp;
        $user_details = UserDetailsModel::where('otp', $otp)->get();;
        if($user_details)
        {
            return view('reset_password');
        }
    }
    public function getNewPassword(Request $req)
    {
        $mail= session('mail');
        $check_mail=UserDetailsModel::where('email',$mail )->update(array('password'=>Hash::make($req->chng_password)));
        session()->pull('mail');
        if($check_mail)
        {
            return view('reset_password');
        }
        
    }
}
