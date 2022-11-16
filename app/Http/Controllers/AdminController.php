<?php

namespace App\Http\Controllers;

use App\Models\UserDetailsModel;
use Illuminate\Http\Request;
use App\Models\GalleryTypesModel;
use App\Models\ImageUploadModel;
use App\Models\UserGalleriesModel;


class AdminController extends Controller
{
    public function loadUserProfilePage()
    {
        $login_id = session('login_id');

        $select_user = UserDetailsModel::where('user_type', 1)->get();

        $select_profile_pic =  ImageUploadModel::select('img_path')
            ->join('user_galleries', 'image_upload.user_gallery_id', '=', 'user_galleries.id')
            ->where('user_galleries.gallery_type_id', '=', 1)
            ->where('image_upload.flag', '=', 1)
            ->where('user_galleries.user_id', '=', $login_id)->get();

      

        return view('user_profile')->with(array('user_details' => $select_user, 'load' => 'user_details', 'select_profile' => $select_profile_pic));
    }
    public function loadAdminDashboard(Request $req)
    {
        return view('admin_page');
    }
    public function userstatus_inactive(Request $req)
    {
        $output = array('dbStatus' => '', 'dbMessage' => '');
        $update_status = UserDetailsModel::where('id', $req->id)
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
        $user_details   = UserDetailsModel::where('user_type', 2);

        if ($search != "") {
            $user_details = $user_details->where(function ($user_details) use ($search) {
                $user_details->where('username', 'like', '%' . $search . '%');
                $user_details->orWhere('address', 'like', '%' . $search . '%');
                $user_details->orWhere('email', 'like', '%' . $search . '%');
            });
        }
        $record_total = $user_details->get();
        $totals       = count($record_total);
        $user_details->offset($start);
        $user_details->limit($limit);
        $user_details = $user_details->get();
        $record_filtered = count($user_details);
        $output['recordsTotal'] = $totals;
        $output['recordsFiltered'] = $record_filtered;
        header('Content-Type: application/json; charset=utf-8');

        foreach ($user_details as $row) {
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
    }
    public function editUserDetails(Request $req)
    {

        $update_user = UserDetailsModel::where('id', $req->user_id)
            ->update(array('username' => $req->user_name, 'email' => $req->mail_id, 'address' => $req->addres, 'phone_no' => $req->mob));

        if ($update_user) {
            return view('admin_page');
        }
    }
    public function deleteUserDetails(Request $req)
    {
        $output = array('dbStatus' => '', 'dbMessage' => '');
        $delete_user = UserDetailsModel::where('id', $req->id)
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
