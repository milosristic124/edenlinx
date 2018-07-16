<?php

namespace App\Http\Controllers\Api;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class User extends Controller
{
    const DESTINATION_PATH = 'uploads/profile';

    public function __construct()
    {
    }

    public function getprofile(Request $request)
	{
		$retval = new \stdClass();
		
        $token = $request['token'];
        $users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
        }
        $user = $users[0];

        $retval->result = "success";
        $retval->data = new \stdClass;
        $retval->err_msg = "";
        $retval->data->u_id = $user->id;
        $retval->data->name = $user->name;
        $retval->data->email = $user->email;
        $retval->data->userrole = $user->userrole;
        $retval->data->phone = $user->userphone;
        $retval->data->profile = $user->userprofile;
        $retval->data->notes = $user->notes;

        return response()->json($retval);
    }

    public function setprofile(Request $request)
	{
		$retval = new \stdClass();
		
        $token = $request['token'];
        $name = $request['name'];
        $email = $request['email'];
        $userrole = $request['userrole'];
        $phone = $request['phone'];
        $profile = self::fileUpload($request, 'profile');
        $notes = $request['notes'];

        $users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
        }
        $user = $users[0];

        DB::update("update users set name = ?, email = ?, userrole = ?, userphone = ?, notes = ? where id = ?",
            [$name, $email, $userrole, $phone, $notes, $user->id]);

        if ($profile != "")
            DB::update("update users set userprofile = ? where id = ?", [$profile, $user->id]);

        $retval->result = "success";
        $retval->data = array();
        $retval->err_msg = "";

        return response()->json($retval);
    }

    public function changepassword(Request $request)
	{
		$retval = new \stdClass();
		
        $token = $request['token'];
        $old_password = $request['old_password'];
        $new_password = $request['new_password'];

        $users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
        }
        $user = $users[0];

        if (!Hash::check($old_password, $user->password))
        {
            $retval->result = "fail";
			$retval->data = array();
			$retval->err_msg = "Old password is wrong";

			return response()->json($retval);
        }

        DB::update("update users set password = ? where id = ?", [Hash::make($new_password), $user->id]);

        $retval->result = "success";
        $retval->data = array();
        $retval->err_msg = "";

        return response()->json($retval);
    }

    private function fileUpload($request, $paramname)
    {
        $file = $request->file($paramname);
        if(isset($file))
        {
            $extention = $file->getClientOriginalExtension();
            $filename = basename($file->path()).'_'.date('His').'.'.$extention;
            $file->move(self::DESTINATION_PATH, $filename);
            $project_image = self::DESTINATION_PATH.'/'.$filename;
        }
        else
            $project_image = "";

        return $project_image;
    }
}