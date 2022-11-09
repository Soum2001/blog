<?php

namespace App\Http\Controllers;
use App\Models\UserDetailsModel;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function loadUserDetails(Request $request){
       
        $output         = array("aaData" => array());
        // $start          = $request->input('start');
        // $limit          = $request->input('length');
		// $search_arr     = $request->input('search');
        // $search         = $search_arr['value'];
        $user_details   = UserDetailsModel::where('user_type',2)->get();

        // if($search != ""){
        //     $user_details = $user_details->where(function($q) 
        //     {
        //         $q->where('username', 'like', '%'.$search.'%');
        //         $q->orWhere('address','like', '%'.$search.'%');
        //         $q->orWhere('email','like', '%'.$search.'%');
        //     });
        // }
        header('Content-Type: application/json; charset=utf-8');

        foreach($user_details as $row)
        {     
            $output['aaData'][]=$row;
        }
        echo json_encode($output);
    }
}
