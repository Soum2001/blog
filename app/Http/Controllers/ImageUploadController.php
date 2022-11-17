<?php

namespace App\Http\Controllers;

use App\Models\GalleryTypesModel;
use App\Models\ImageUploadModel;
use App\Models\UserGalleriesModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
//use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use App\Models\UserDetailsModel;
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

        $output = array();
        $image_upload   = new ImageUploadModel;
        $gallery_type   = new GalleryTypesModel;
        $user_gallery   = new UserGalleriesModel;
        if ($request->hasfile('profile_imgupload')) {
            $image      =   $request->file('profile_imgupload');
            $image_name =   $image->getClientOriginalName();
            $file_type  =   $image->getClientMimeType();
            $new_image = $image->hashName();
            $login_id = session('login_id');

            //$path='var/www/upload';
            // echo(base_path());
            //File::makeDirectory($path, $mode = 0777, true, true);
            $image_url = $image->move(storage_path() . '/app/public/', $new_image);

            //check gallery_type exist or not
            $check_gallery_type = GalleryTypesModel::where('id', '=', $request->type)->get();

            foreach ($check_gallery_type as $row) {

                $gallery_type_id  = $row->id;
            }

            if (!empty($check_gallery_type)) {

                // check existance in user_galleries
                $check_user_galleries   = UserGalleriesModel::where('gallery_type_id', '=', $gallery_type_id)->where('user_id', '=', $login_id)->get();

                foreach ($check_user_galleries as $row) {
                    $user_galleries_id  = $row->id;
                }


                //print_r($check_user_galleries);
                if (sizeof($check_user_galleries)) {
                    $image_upload_update = ImageUploadModel::where('user_gallery_id', '=', $user_galleries_id)->update(['flag' => 0]);

                    $image_upload->img_path          =   $new_image;
                    $image_upload->user_gallery_id   =   $user_galleries_id;
                    $image_upload->flag              =   1;
                    $image_upload->save();
                } else {

                    $user_gallery->user_id         =   $login_id;
                    $user_gallery->gallery_type_id =   $gallery_type_id;
                    $user_gallery->save();

                    $image_upload->img_path          =   $new_image;
                    $image_upload->user_gallery_id   =   $user_gallery->id;
                    $image_upload->flag              =   1;
                    $image_upload->save();
                }
            }
            $output['success'] = 1;
            $output['msg'] = 'image uploaded';
            // }else{

            // }
            //echo($image_url);
            //$image->move('var/www/upload',$new_image);


        }
        return response()->json($output);
    }
    function fetchGalleries()
    {
        $login_id = session('login_id');
        $select_user_galleries  =   GalleryTypesModel::select('gallery_type.gallery_name', 'gallery_type.id')
            ->join('user_galleries', 'user_galleries.gallery_type_id', '=', 'gallery_type.id')
            ->where('user_galleries.user_id', '=', $login_id)->get();

        $select_user = UserDetailsModel::where('user_type', 1)->get();

        $select_profile_pic =  ImageUploadModel::select('img_path')
            ->join('user_galleries', 'image_upload.user_gallery_id', '=', 'user_galleries.id')
            ->where('user_galleries.gallery_type_id', '=', 1)
            ->where('image_upload.flag', '=', 1)
            ->where('user_galleries.user_id', '=', $login_id)->get();

        return view('user_profile')->with(array('user_details' => $select_user, 'gallery_type' => $select_user_galleries, 'load' => 'gallery', 'select_profile' => $select_profile_pic));
    }
    function loadImages(Request $request)
    {
        // $output = array('img_path' => array());
        $gallery_id =   $request->input('gallery_id');

        $login_id = session('login_id');

        $select_image  =   ImageUploadModel::select('image_upload.img_path', 'image_upload.id')
            ->join('user_galleries', 'user_galleries.id', '=', 'image_upload.user_gallery_id')
            ->where('user_galleries.user_id', '=', $login_id)
            ->where('user_galleries.gallery_type_id', '=', $gallery_id)
            ->get();
        if (empty($select_image)){
            echo('hi');
            $output = '<p style="width:100%;height:100px;text-align:center;color:black;font-Size:40px">No Image Found For This Gallery</p>';
        } else {
            
            $output = '<div class="row">';
            foreach ($select_image as $image) {
                $img = (asset('storage') . '/' . $image->img_path);
                $output .=  '
                <div class="col-sm-4">
                <img class="img-fluid pad" style="height:318px;width:496px" src=' . "$img" . '>
                    <input type="checkbox" class="delete-checkbox" id=' . $image->id . '>
                    <p>Profile_Image.jpg</p>
                    <button type="button" class="btn btn-outline-danger  btn-xs float-right" onclick="remove_pic(' . $image->id . ')"><i class="fas fa-trash"></i> Remove</button>
                    <button type="button" class="btn btn-outline-dark  btn-xs float-right" onclick="set_profile_pic(' . $image->id . ')">Set Profile Pic</button>
                    <span class="float-left text-xs">
                        <strong>Uploaded On:</strong>
                        <i>15th November, 2022</i>
                    </span>
                    </div>';
            }
            $output .=  '</div>';
        }
        // foreach ($select_image as $image) {

        //     // $imageData = base64_encode(file_get_contents(asset('storage').'/'.$image->img_path));

        //     // // Format the image SRC:  data:{mime};base64,{data};
        //     // $src = 'data: '.mime_content_type($image->img_path).';base64,'.$imageData;
        //     // $output['img_path'][]=$src;
        //     $output['img_path'][] = (asset('storage') . '/' . $image->img_path);
        // }

        // $output['load']='image';

        return response()->json($output);
    }
    function loadNewGallery(Request $request)
    {
        $output       =   array("dbStatus" => '', 'dbMessage' => '');
        $login_id     = session('login_id');
        $user_gallery = new UserGalleriesModel;
        $gallery_type = new GalleryTypesModel;
        $gallery_id   = "";

        $check_gallery_existance  = GalleryTypesModel::where('gallery_name', '=', $request->new_gallery_name)->get();
        foreach ($check_gallery_existance as $row) {
            $gallery_id =   $row->id;
        }

        if ($gallery_id !=  "") {

            $check_user_gallery =  UserGalleriesModel::where('gallery_type_id', '=', $gallery_id)->where('user_id', '=', $login_id)->get();

            if ($check_user_gallery) {
                $output['dbStatus']  =  0;
                $output['dbMessage'] = 'This gallery already exist for this user';
            } else {
                $user_gallery->user_id          =   $login_id;
                $user_gallery->gallery_type_id  =   $gallery_id;

                if ($user_gallery->save()) {
                    $output['dbStatus'] =  1;
                    $output['dbMessage'] =  'New Gallery Created';
                } else {
                    $output['dbStatus'] =  0;
                    $output['dbMessage'] =  'Some error Occured';
                }
            }
        } else {

            $gallery_type = new GalleryTypesModel;
            $gallery_type->gallery_name = $request->new_gallery_name;
            if ($gallery_type->save()) {
                $gallery_type_id = $gallery_type->id;

                $user_gallery->user_id          =   $login_id;
                $user_gallery->gallery_type_id  =   $gallery_type_id;

                if ($user_gallery->save()) {

                    $output['dbStatus'] =  1;
                    $output['dbMessage'] =  'New Gallery Created';
                } else {
                    $output['dbStatus'] =  0;
                    $output['dbMessage'] =  'Some error Occured';
                }
            }
        }
        return response()->json($output);
    }
    function delete_photos(Request $request)
    {
        $output =   array('dbStatus' => '', 'dbMessage' => '');
        if (empty($request->delete_id)) {

            $output['dbStatus'] =  0;
            $output['dbMessage'] =  'Please select image to delete';
        } else {

            $delete_pics  =   ImageUploadModel::whereIn('id', $request->delete_id)->delete();

            if ($delete_pics) {
                $output['dbStatus'] =  1;
                $output['dbMessage'] =  'Photos Deleted';
            } else {
                $output['dbStatus'] =  0;
                $output['dbMessage'] =  'Some error Occured';
            }
        }
        return response()->json($output);
    }
    function remove_pic(Request $request)
    {
        $output =   array('dbStatus' => '', 'dbMessage' => '');
        $delete_pics  =   ImageUploadModel::where('id', $request->pic_id)->delete();

        if ($delete_pics) {
            $output['dbStatus'] =  1;
            $output['dbMessage'] =  'Photo Deleted';
        } else {
            $output['dbStatus'] =  0;
            $output['dbMessage'] =  'Some error Occured';
        }

        return response()->json($output);
    }
    function set_profile_pic(Request $request)
    {
        $output =   array('dbStatus' => '', 'dbMessage' => '');
        $select_user_gallery_id  =   ImageUploadModel::where('id', $request->pic_id)->get();
        foreach ($select_user_gallery_id as $user_gallery_id) {
            $user_gallery_id = $user_gallery_id->user_gallery_id;
        }
        if ($select_user_gallery_id) {
            $update_flag_zero  =   ImageUploadModel::where('user_gallery_id', $user_gallery_id)->update(array('flag' => 0));
        }
        if ($update_flag_zero) {
            $update_flag_one  =   ImageUploadModel::where('id', $request->pic_id)->update(array('flag' => 1));
        }
        if ($update_flag_one) {
            $output['dbStatus'] =  1;
            $output['dbMessage'] =  'Profile Pic Uploaded';
        } else {
            $output['dbStatus'] =  0;
            $output['dbMessage'] =  'Some error Occured';
        }

        return response()->json($output);
    }
}
