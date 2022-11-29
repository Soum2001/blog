<?php

namespace App\Http\Controllers;
use Illuminate\Notifications\Notification;
use App\Models\GalleryTypesModel;
use App\Models\ImageUploadModel;
use App\Models\UserGalleriesModel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
//use Facade\FlareClient\Stacktrace\File;
use Illuminate\Http\Request;
use App\Models\User;
//use Facade\FlareClient\Http\Client;

use PhpOption\None;
use PhpParser\Node\Expr\Empty_;
use PhpParser\Node\Expr\Throw_;
use Throwable;
use Twilio\Rest\Client;
use App\Notifications\OrderProcessed;

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
                    $image_upload->created_at        =   now();
                    $image_upload->updated_at         =   now();
                    $image_upload->save();
                } else {

                    $user_gallery->user_id         =   $login_id;
                    $user_gallery->gallery_type_id =   $gallery_type_id;
                    $user_gallery->created_at      =   now();
                    $user_gallery->updated_at      =   now();
                    $user_gallery->save();

                    $image_upload->img_path          =   $new_image;
                    $image_upload->user_gallery_id   =   $user_gallery->id;
                    $image_upload->flag              =   1;
                    $image_upload->created_at        =   now();
                    $image_upload->updated_at         =   now();
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
    function fetchGalleries(Request $request)
    {
        if ($request->user_id == '') {
            $login_id = session('login_id');
        } else {
            session()->pull('login_id');
            session()->put('login_id', $request->user_id);
            $login_id = session('login_id');
        }
        $user_type = session('user_type');

        $select_user_galleries  =   GalleryTypesModel::select('gallery_type.gallery_name', 'gallery_type.id')
            ->join('user_galleries', 'user_galleries.gallery_type_id', '=', 'gallery_type.id')
            ->where('user_galleries.user_id', '=', $login_id)->get();

        $select_user = User::where('id', $login_id)->get();

        $select_all_user = User::where('user_type', 2)->get();

        $select_profile_pic =  ImageUploadModel::select('img_path')
            ->join('user_galleries', 'image_upload.user_gallery_id', '=', 'user_galleries.id')
            ->where('user_galleries.gallery_type_id', '=', 1)
            ->where('image_upload.flag', '=', 1)
            ->where('user_galleries.user_id', '=', $login_id)->get();

        $select_banner_pic =  ImageUploadModel::select('img_path')
            ->join('user_galleries', 'image_upload.user_gallery_id', '=', 'user_galleries.id')
            ->where('user_galleries.gallery_type_id', '=', 2)
            ->where('image_upload.flag', '=', 1)
            ->where('user_galleries.user_id', '=', $login_id)->get();

        //print_r($select_banner_pic->img_path);

        return view('user_profile')->with(array('user_type' => $user_type, 'all_user_name' => $select_all_user, 'user_details' => $select_user, 'gallery_type' => $select_user_galleries, 'load' => 'gallery', 'select_banner' => $select_banner_pic, 'select_profile' => $select_profile_pic));
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
        if ($gallery_id != 1 && $gallery_id != 2) {
            
                $output = '<div class="row">
                            <div class="col-sm-4">
                            
                                <button class="btn btn-primary">
                                    <input type="file" id="custom_img" name="custom_img" onchange="crop_class.load_custom(this,' . $gallery_id . ')">
                                </button>
                                <button type="button" class="btn btn-primary" id="crop-custom-img">Upload</button>
                            
                            </div>';
           
                foreach ($select_image as $image) {
                    $img = (asset('storage') . '/' . $image->img_path);
                    $output .=  '
                            <div class="col-sm-4">
                                <img class="img-fluid pad" style="height:318px;width:496px" src=' . "$img" . '>
                                <input type="checkbox" class="delete-checkbox" id=' . $image->id . '>
                                <p>Profile_Image.jpg</p>
                                <button type="button" class="btn btn-outline-danger  btn-xs float-right" onclick="remove_pic(' . $image->id . ','.$gallery_id.')"><i class="fas fa-trash"></i> Remove</button>';
                                if ($gallery_id == 1)
                                {
                                $output .=  '<button type="button" class="btn btn-outline-dark  btn-xs float-right" onclick="set_profile_pic(' . $image->id . ')">Set Profile Pic</button>';
                                }
                                $output .= ' <span class="float-left text-xs">
                                    <strong>Uploaded On:</strong>
                                    <i>15th November, 2022</i>
                                </span>
                            </div>';
                }
        } else {
            if (empty($select_image)) {
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
                    <button type="button" class="btn btn-outline-danger  btn-xs float-right" onclick="remove_pic(' . $image->id . ','.$gallery_id.')"><i class="fas fa-trash"></i> Remove</button>';
                    if ($gallery_id == 1)
                    {
                    $output .=  '<button type="button" class="btn btn-outline-dark  btn-xs float-right" onclick="set_profile_pic(' . $image->id . ')">Set Profile Pic</button>';
                    }
                    $output .= ' <span class="float-left text-xs">
                        <strong>Uploaded On:</strong>
                        <i>15th November, 2022</i>
                    </span>
                </div>';
                }
            }
            //$output .=  $select_image->links();
        }
        $output .=  '</div>';
        // // foreach ($select_image as $image) {

        // //     // $imageData = base64_encode(file_get_contents(asset('storage').'/'.$image->img_path));

        // //     // // Format the image SRC:  data:{mime};base64,{data};
        // //     // $src = 'data: '.mime_content_type($image->img_path).';base64,'.$imageData;
        // //     // $output['img_path'][]=$src;
        // //     $output['img_path'][] = (asset('storage') . '/' . $image->img_path);
        // // }

        // // $output['load']='image';

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
            $gallery_type->created_at   = now();
            $gallery_type->updated_at   = now();
            if ($gallery_type->save()) {
                $gallery_type_id = $gallery_type->id;

                $user_gallery->user_id          =   $login_id;
                $user_gallery->gallery_type_id  =   $gallery_type_id;
                $user_gallery->created_at       =   now();
                $user_gallery->updated_at       =   now();
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
        // $select_galley_id  =   UserGalleriesModel::select('user_galleries.gallery_type_id')
        // ->join('user_galleries', 'user_galleries.id', '=', 'image_upload.user_gallery_id')
        // ->whereIn('id', $request->pic_id)
        // ->get();
        //echo($select_galley_id );
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

        $output       =   array('dbStatus' => '', 'dbMessage' => '');
        
        // $delete_pics  =   UserGalleriesModel::select('user_galleries.gallery_type_id')
        //     ->join('user_galleries', 'user_galleries.id', '=', 'image_upload.user_gallery_id')
        //     ->where('id', $request->pic_id)
        //     ->get();
        // echo ($delete_pics);
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
            if ($update_flag_zero) {
                $update_flag_one  =   ImageUploadModel::where('id', $request->pic_id)->update(array('flag' => 1));
                if ($update_flag_one) {
                    $output['dbStatus'] =  1;
                    $output['dbMessage'] =  'Profile Pic Uploaded';
                } else {
                    $output['dbStatus'] =  0;
                    $output['dbMessage'] =  'Some error Occured';
                }
            }
        }
        return response()->json($output);
    }
    function editUser(Request $request)
    {
        $output =   array('dbStatus' => '', 'dbMessage' => '');
        $update_user = User::where('id', $request->id)
                 ->update(array('name' => $request->name, 'email' => $request->email, 'address' => $request->address, 'phone_no' => $request->phn_no));
        if($update_user)
        {
            $output['dbStatus'] =  1;
            $output['dbMessage'] =  'Profile Updated';
        }else {
            $output['dbStatus'] =  0;
            $output['dbMessage'] =  'Some error Occured';
        }
        return response()->json($output);
    }
    function send(Request $request)
    {
        // try{

        //     $to = $notifiable->routeNotificationFor('WhatsApp');
        //     $from = config('services.twilio.whatsapp_from');
        //     $account_sid = env('TWILIO_SID');
        //     $account_token =env('TWILIO_AUTH_TOKEN');
        //     $number =env('TWILIO_WHATSAPP_NUMBER');

        //     $client = new Client($account_sid,$account_token);
    
        //     $client->messages->create('+916371668018',[
        //         'from'=>$number,
        //         'body'=>'hi'
        //     ]);
        //     return 'message sent';
        // }
        // catch(Throwable $e){
        //     return $e->getMessage();
        // }
     
        $body  =   ImageUploadModel::whereIn('id', $request->pic_id)->get();
        echo(storage_path() . '/app/public/'.$body[0]['img_path']);
        $sid    = env("TWILIO_SID");
        $token  = env("TWILIO_AUTH_TOKEN");
        $wa_from= env("TWILIO_WHATSAPP_NUMBER");
        $twilio = new Client($sid, $token);
        
        //$body = "Hello, welcome to codelapan.com.";
        return $twilio->messages->create("whatsapp:+916371668018",["from" => "whatsapp:$wa_from", "mediaUrl" => storage_path() . '/app/public/'.$body[0]['img_path']]);
    }
    // public function send($notifiable, Notification $notification)
    // {
    //     $message = $notification->toWhatsApp($notifiable);


    //     $to = $notifiable->routeNotificationFor('WhatsApp');
    //     $from = config('services.twilio.whatsapp_from');


    //     $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));


    //     return $twilio->messages->create('whatsapp:' . $to, [
    //         "from" => 'whatsapp:' . $from,
    //         "body" => $message->content
    //     ]);
    // }
}
