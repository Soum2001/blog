<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PharIo\Manifest\AuthorCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtp;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    //
    // public function __construct()
    // {
    //     $this->middleware('auth:web');
    // }
    function loadRegistrationPage()
    {
        // $user= User::all();
        // return $user;
        return view('register');
    }
    function loadForgetPasswordPage()
    {
        // $user= User::all();
        // return $user;
        return view('forget_password');
    }
    function formData(Request $request)
    {

        //print_r($request->input());
        //$output = array('dbStatus'=>'','dbMessage'=>'');
        $user             = new User;
        $user->name   = $request->user_name;
        $hashedPassword           = Hash::make($request->password);
        $user->password   = $hashedPassword;
        //Hash::make('secret');
        $user->email          = $request->email;
        $user->address        = $request->addres;
        $user->phone_no       = $request->phnno;
        $user->user_type      = 2;
        $user->_token         = $request->_token;
        $user->active         = 1;

        // $user->created_at = now();
        // $user->updated_at = now();
        $user->save();
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
        echo($request->id);

        $input = $request->all();
        $input   = $request->only('email', 'password');
        if (Auth::attempt($input)) {

            $user = User::where('email', Auth::user()->email)->first();
            session()->put('login_id', $user->id);

            if (Auth::user()->user_type == 1) {
                session()->put('user_type', 'admin');
                return redirect('/admindashboard');
            } else {
                session()->put('user_type', 'user');
                return redirect('/dashboard');
            }
        } else {
            return back()->with('error', 'username and passsword is incorrect');
        }
    }
    // public function loadLogin()
    // {
    //     if(Auth::user() && Auth::user()->user_type == 1)
    //     {
    //         return redirect('/admindashboard');
    //     }
    //     else if(Auth::user() && Auth::user()->user_type == 2)
    //     {
    //         return redirect('/dashboard');
    //     }
    //     return view('welcome');
    // }
    public function requestPassword(Request $request)
    {
        $otp = rand(100000, 999999);
        Log::info("otp = " . $otp);
        $user = User::where('email', '=', $request->otp_email)->update(['otp' => $otp]);

        if ($user) {

            $mail_details = [
                //'subject' => 'Testing Application OTP',
                'otp' => $otp
            ];

            Mail::to($request->otp_email)->send(new SendOtp($mail_details));

            session()->put('mail', $request->otp_email);

            return view("otp_front");
        } else {
            return 'Invalid';
        }
    }
    public function verifyOtp(Request $request)
    {
        $otp          = $request->otp;
        $user = User::where('otp', $otp)->get();;
        if ($user) {
            return view('reset_password');
        }
    }
    public function getNewPassword(Request $req)
    {
        $mail = session('mail');
        $check_mail = User::where('email', $mail)->update(array('password' => Hash::make($req->chng_password)));
        session()->pull('mail');
        if ($check_mail) {
            return view('reset_password');
        }
    }
    public function loadAdminPage()
    {
        return view('admin_page');
    }
    public function loadUserPage()
    {
        
        return view('user');
    }
    public function logOut(Request $request)
    {
        //echo ('hi');
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }
}
