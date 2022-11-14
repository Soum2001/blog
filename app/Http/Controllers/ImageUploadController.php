<?php

namespace App\Http\Controllers;

use App\Models\GalleryTypesModel;
use App\Models\ImageUploadModel;
use App\Models\UserGalleriesModel;

use Illuminate\Support\Facades\Storage;
//use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use PhpOption\None;
use PhpParser\Node\Expr\Empty_;

class ImageUploadController extends Controller
{
    function imageUpload(Request $request)
    {
        // $validatedData = $request->validate([
        //     'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
   
        //    ]);
        
       //dd($request->all(),$request->has('profile_imgupload'));
       $output=array();
        $image_upload   = new ImageUploadModel;
        $gallery_type   = new GalleryTypesModel;
        $user_gallery   = new UserGalleriesModel;
        if($request->hasfile('profile_imgupload'))
        {
            $image      =   $request->file('profile_imgupload');
            $image_name =   $image->getClientOriginalName();
            $file_type  =   $image->getClientMimeType();
            $new_image=$image->hashName();
            $login_id= session('login_id');
            
            //$path='var/www/upload';
            // echo(base_path());
            //File::makeDirectory($path, $mode = 0777, true, true);
            $image_url = $image->move(base_path().'/storage/images/',$new_image);

            //check gallery_type exist or not
            $check_gallery_type = GalleryTypesModel::where('id','=',$request->type)->get();
            
            foreach($check_gallery_type as $row)
            {
                
                $gallery_type_id  = $row->id;
             
            }
           
            if(!empty($check_gallery_type))
            {
               
               // check existance in user_galleries
                $check_user_galleries   = UserGalleriesModel::where('gallery_type_id','=',$gallery_type_id)->where('user_id','=',$login_id)->get();
               
                foreach($check_user_galleries as $row)
                { 
                    $user_galleries_id  = $row->id;   
                }

              
                //print_r($check_user_galleries);
                if(sizeof($check_user_galleries ))
                {   
                    $image_upload_update = ImageUploadModel::where('user_gallery_id','=',$user_galleries_id)->update(['flag' => 0]);

                    $image_upload->img_path          =   $new_image;
                    $image_upload->user_gallery_id   =   $user_galleries_id ;
                    $image_upload->flag              =   1;  
                    $image_upload->save();
                    
                    
                }else{
                    
                    $user_gallery->user_id         =   $login_id;
                    $user_gallery->gallery_type_id =   $gallery_type_id;
                    $user_gallery->save();

                    $image_upload->img_path          =   $new_image;
                    $image_upload->user_gallery_id   =   $user_gallery->id ;
                    $image_upload->flag              =   1;  
                    $image_upload->save();
                }
               
            }
            $output['success']=1;
            $output['msg']='image uploaded';
            // }else{
                
            // }
            //echo($image_url);
            //$image->move('var/www/upload',$new_image);
           
        
        }
        return response()->json($output);
    }
   
}
