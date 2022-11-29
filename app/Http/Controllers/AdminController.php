<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\GalleryTypesModel;
use App\Models\ImageUploadModel;
use App\Models\UserGalleriesModel;


class AdminController extends Controller
{
    public function loadUserProfilePage()
    {
        $login_id = session('login_id');
        $user_type = session('user_type');
        $select_user = User::where('id','=',$login_id)->get();

        $select_profile_pic =  ImageUploadModel::select('img_path')
            ->join('user_galleries', 'image_upload.user_gallery_id', '=', 'user_galleries.id')
            ->where('user_galleries.gallery_type_id', '=', 1)
            ->where('image_upload.flag', '=', 1)
            ->where('user_galleries.user_id', '=', $login_id)->get();

      

        return view('user_profile')->with(array('user_type'=>$user_type,'user_details' => $select_user, 'load' => 'user_details', 'select_profile' => $select_profile_pic));
    }
    public function loadAdminDashboard(Request $req)
    {
        $login_id = session('login_id');
        $select_profile_pic =  ImageUploadModel::select('img_path')
        ->join('user_galleries', 'image_upload.user_gallery_id', '=', 'user_galleries.id')
        ->where('user_galleries.gallery_type_id', '=', 1)
        ->where('image_upload.flag', '=', 1)
        ->where('user_galleries.user_id', '=', $login_id)->get();

        return view('admin_page')->with(array('select_profile' => $select_profile_pic));
    }
    public function userstatus_inactive(Request $req)
    {
        $output = array('dbStatus' => '', 'dbMessage' => '');
        $update_status = User::where('id', $req->id)
            ->update(array('active' => $req->state));
        if ($update_status) {
            $output['dbStatus']  = 'SUCCESS';
            $output['dbMessage'] = 'Status Changed.';
        } else {
            $output['dbStatus']  = 'FAILURE';
            $output['dbMessage'] = 'OOPS! Someting Went Wrong in delete Operation.';
        }
        echo json_encode($output);
    }
    function loadUserDetails(Request $request)
    {

        $output         = array("aaData" => array(), 'dbStatus' => '', 'recordsTotal' => 0, 'recordsFiltered' => 0);
        $start          = $request->input('start');
        $limit          = $request->input('length');
        $search_arr     = $request->input('search');
        $search         = $search_arr['value'];
        $user   = User::where('user_type', 2);

        if ($search != "") {
            $user = $user->where(function ($user) use ($search) {
                $user->where('username', 'like', '%' . $search . '%');
                $user->orWhere('address', 'like', '%' . $search . '%');
                $user->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $record_total = $user->get();
        $totals       = count($record_total);
        $user->offset($start);
        $user->limit($limit);
        $user = $user->get();
        $record_filtered = count($user);
        $output['recordsTotal'] = $totals;
        $output['recordsFiltered'] = $record_filtered;
        header('Content-Type: application/json; charset=utf-8');

        foreach ($user as $row) {
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }
    public function editUserDetails(Request $req)
    {
        $update_user = User::where('id', $req->user_id)
            ->update(array('name' => $req->user_name, 'email' => $req->mail_id, 'address' => $req->addres, 'phone_no' => $req->mob));

        if ($update_user) {
            return view('admin_page');
        }
    }
    public function deleteUserDetails(Request $req)
    {
        $output = array('dbStatus' => '', 'dbMessage' => '');
        $delete_user = User::where('id', $req->id)
            ->delete();

        if ($delete_user) {
            $output['dbStatus']  = 'SUCCESS';
            $output['dbMessage'] = 'Data Deleted.';
        } else {
            $output['dbStatus']  = 'FAILURE';
            $output['dbMessage'] = 'OOPS! Someting Went Wrong in delete Operation.';
        }
        return response()->json($output);
    }
}
