<?php

namespace App\Http\Controllers\Api;

use DB;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class Auth extends Controller
{
	public function make_token() {
        $bExist = 1;
        $length = 20;
        $rescode = "";
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
        $charactersLength = strlen($characters);
        
        while ($bExist)
        {
            $rescode = "";
            for ($i = 0; $i < $length; $i++) {
                $rescode .= $characters[rand(0, $charactersLength - 1)];
            }
            $check = DB::select("select count(id) as usercount from users where app_token = '?'", [$rescode]);
            $bExist = $check[0]->usercount;
        }

        return $rescode;
	}
	
	public function login(Request $request)
	{
		$retval = new \stdClass();

		$token = $request['token'];
		$email = $request['email'];
		$password = $request['password'];

		$users = array();
		if ($token != "" || $token != null)
			$users = DB::select("select * from users where app_token = ?", [$token]);
			
		if (count($users) == 0)
		{
			$users = DB::select("select * from users where email = ? and userrole <> 'admin'", [$email]);
			if (count($users) > 0)
			{
				if (!Hash::check($password, $users[0]->password))
					$users = array();
			}
		}

		if (count($users) > 0)
		{
			$user = $users[0];
			$retval->result = "success";
			$retval->data = new \stdClass();
			$retval->data->u_id = $user->id;
			$retval->data->userrole = $user->userrole;
			if ($retval->data->userrole == "business")
			{
				$businesses = DB::select("select * from business where userid = ?", [$retval->data->u_id]);
				if (count($businesses) > 0)
					$retval->data->b_id = $businesses[0]->b_id;
			}
			$retval->data->username = $user->name;
			$retval->data->token = Auth::make_token();
			$retval->data->avatar = $user->userprofile;

			DB::update("update users set app_token = ? where id = ?", [$retval->data->token, $retval->data->u_id]);

			$retval->err_msg = "";
		}
		else
		{
			$retval->result = "fail";
			$retval->data = array();
			$retval->err_msg = "Invalid email or password";
		}

		return response()->json($retval);
	}

	public function register(Request $request){
		$retval = new \stdClass();

		$username = $request['username'];
		$email = $request['email'];
		$password = $request['password'];
		$userrole = $request['userrole'];
		$companyname = $request['companyname'];

		$users = DB::select("select * from users where name = ?", [$username]);
		
		if (count($users) == 0)
		{

			$users = DB::select("select * from users where email = ?", [$email]);

			if (count($users) == 0)
			{
				
				$userid = DB::table('users')->insertGetId(['name'=>$username, 'email'=>$email, 'password'=>Hash::make($password), 'userrole'=>$userrole, 'companyname'=>$companyname, 'package'=>'free',
				'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);
				
				if ($userrole == "business") {
					DB::table('business')->insert(['userid'=>$userid, 'b_title'=>'Default Business', 'b_category'=>'Default Category', 'b_keyword'=>'Default',
						'b_image'=>'https://placehold.it/468x265?text=IMAGE', 'b_headerimage'=>'https://placehold.it/1200x400?text=IMAGE']);
				}

				$retval->result = "success";
				$retval->data = array();
				$retval->err_msg = "";
			}
			else
			{
				$retval->result = "fail";
				$retval->data = array();
				$retval->err_msg = "Email is already exist";
			}
		}
		else
		{
			$retval->result = "fail";
			$retval->data = array();
			$retval->err_msg = "Username is already exist";
		}

		return response()->json($retval);
	}

	public function logout(Request $request){
		$retval = new \stdClass();

		$token = $request['token'];

		$retval->result = "success";
		$retval->data = array();
		$retval->err_msg = "";

		DB::update("update users set app_token = '' where app_token = ?", [$token]);
	}

	/*
    public function login(Request $request){
    	try {

    		$data = $request->all();

   			$validator = Validator::make($data, [
			    'email' => 'required|string|email|max:255',
	            'password' => 'required|string|min:6',
			]);

   			if ($validator->fails())
			    return response()->json(['errors' => $validator->messages()], Response::HTTP_UNPROCESSABLE_ENTITY);

   			if ( !JWTAuth::attempt($data)) {
	       		return response()->json(['errors' => 'username or password incorrect'], Response::HTTP_UNAUTHORIZED);
	   		}

	   		$user = User::where('email', $data['email'])->first();

	   		$token = JWTAuth::fromUser($user, ['user' => $user]);

	   		return response()->json(compact('token'));
   			
   		} catch (Exception $e) {
   			
   			return response()->json(['errors' => $e->getMessage()], Response::HTTP_CONFLICT);
   		}
    }

    public function register(Request $request){

   		try {

   			$data = $request->all();

   			$validator = Validator::make($data, [
			    'name' => 'required|string|max:255',
	            'email' => 'required|string|email|max:255|unique:users',
	            'password' => 'required|string|min:6|confirmed',
	            'userrole' => 'required|string',
	            'companyname' => 'nullable|string',
	            'package' => 'required|string',
			]);

   			if ($validator->fails())
			    return response()->json(['errors' => $validator->messages()], Response::HTTP_UNPROCESSABLE_ENTITY);

			$user = User::create([
	            'name' => $data['name'],
	            'email' => $data['email'],
	            'password' => bcrypt($data['password']),
	            'companyname' => isset($data['companyname'])? $data['companyname'] : '',
	            'package' => $data['package'],
	            'userrole' => $data['userrole'],
	        ]);

	        $token = JWTAuth::fromUser($user, ['user' => $user]);

   			return response()->json(compact('token'), 200);
   			
   		} catch (Exception $e) {
   			
   			return response()->json(['errors' => $e->getMessage()], Response::HTTP_CONFLICT);
   		}    	
    }

    public function forgotPassword(Request $request){

    	try {

   			$validator = Validator::make($request->all(), [
			    'email' => 'required|string|email|max:255',
			]);

   			if ($validator->fails())
			    return response()->json(['errors' => $validator->messages()], Response::HTTP_UNPROCESSABLE_ENTITY);

			$response = Password::sendResetLink($request->only('email'), function (Message $message) {
	           $message->subject('Your Password Reset Link');
	        });

	   		switch ($response) {
				case Password::RESET_LINK_SENT:
				   return response()->json(['status'=>1, 'message'=>'password sent'], Response::HTTP_OK);

				case Password::INVALID_USER:
				   return response()->json(['errors'=>'user with this email not found'], Response::HTTP_NOT_FOUND);
			}
   			
   		} catch (Exception $e) {
   			
   			return response()->json(['errors' => $e->getMessage()], Response::HTTP_CONFLICT);
   		}
    }

    public function resetPassword(Request $request){

    	try {

   			$validator = Validator::make($request->all(), [
			    'token' => 'required',
				'email' => 'required|email',
				'password' => 'required|confirmed',
			]);

   			if ($validator->fails())
			    return response()->json(['errors' => $validator->messages()], Response::HTTP_UNPROCESSABLE_ENTITY);

			$credentials = $request->only(
	           'email', 'password', 'password_confirmation', 'token'
	       );

			$response = Password::reset($credentials, function ($user, $password) {
				$user->password = bcrypt($password);
       			$user->save();
			});

			switch ($response) {
				case Password::PASSWORD_RESET:
					return response()->json(["message"=>"succesfully reset password"], Response::HTTP_OK);

				default:
				   return response()->json(['errors'=> trans($response)], Response::HTTP_CONFLICT);
			}
   			
   		} catch (Exception $e) {
   			
   			return response()->json(['errors' => $e->getMessage()], Response::HTTP_CONFLICT);
   		}
    }

    public function logout(){

   		try {

   			JWTAuth::invalidate(JWTAuth::getToken());

   			return response()->json('succesfully logged out', 200);
   			
   		} catch (Exception $e) {
   			
   			return response()->json(['errors' => $e->getMessage()], Response::HTTP_CONFLICT);
   		}    	
	}
	*/
}
