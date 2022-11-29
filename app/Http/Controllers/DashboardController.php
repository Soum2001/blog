<?php

namespace App\Http\Controllers;
use App\Models\GalleryTypesModel;
use App\Models\ImageUploadModel;
use App\Models\UserGalleriesModel;
use Illuminate\Http\Request;
Use \Carbon\Carbon;

class DashboardController extends Controller
{
    function dashboard_page()
    {
     
        $login_id   = session('login_id');
        $user_type = session('user_type');
        $gallery_id = array();
        $date       = array();
        $no_of_galleries       =  UserGalleriesModel::where('user_id',$login_id)->get();
        
        foreach($no_of_galleries as $row)
        {
            array_push($gallery_id,$row->id);
        }
        $no_of_images          =  ImageUploadModel::whereIn('user_gallery_id',$gallery_id)->get();
        // foreach($no_of_images as $row)
        // {
        //     $data = $row->created_at;
        //     echo(explode(' ',$data));
        //     // array_push($date,explode('',$date->created_at));
        // }
       // print_r($date);
        $no_of_images          =  $no_of_images->count(); 
        $no_of_galleries       =  $no_of_galleries->count();

        $select_profile_pic =  ImageUploadModel::select('img_path')
        ->join('user_galleries', 'image_upload.user_gallery_id', '=', 'user_galleries.id')
        ->where('user_galleries.gallery_type_id', '=', 1)
        ->where('image_upload.flag', '=', 1)
        ->where('user_galleries.user_id', '=', $login_id)->get();
        
        return view('user_profile')->with(array('user_type'=>$user_type,'images'=>$no_of_images ,'galleries'=>$no_of_galleries, 'load'=>'dashboard','select_profile' => $select_profile_pic));
    }
}