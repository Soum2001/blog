<?php

namespace App\Http\Controllers;

use App\Models\UserDetailsModel;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    //
    function loadRegistrationPage(){
        // $user_details= UserDetailsModel::all();
        // return $user_details;
        return view('register');
    }

    function formData(Request $request){
        // print_r($request->input());
        $user_details             = new UserDetailsModel;
        $user_details->username   = $request->user_name;
        $user_details->password   = $request->password;
        $user_details->email      = $request->email;
        $user_details->address    = $request->addres;
        $user_details->phone_no   = $request->phnno;
        $user_details->user_type  = 1;
        $user_details->active     = 1;
        // $user_details->created_at = now();
        // $user_details->updated_at = now();
        $user_details->save();
    }
    
}
