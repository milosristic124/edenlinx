<?php

namespace App\Http\Controllers\Api;


use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class Project extends Controller
{

	const DESTINATION_PATH = 'uploads/project';

    public function __construct()
    {
    }

    public function projectlist(Request $request)
	{
		$retval = new \stdClass();
		
        $token = $request['token'];
        $type = $request['type'];
        $pagesize = isset($request['pagesize']) && $request['pagesize'] != "" ? $request['pagesize'] : 0;
        $pagenum = isset($request['pagenum']) && $request['pagenum'] != "" ? $request['pagenum'] : 0;

        $users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
        }
        $user = $users[0];

        $business = DB::select("select * from business where userid = ?", [$user->id])[0];
        if ($user->userrole == "customer")
        {
            $countSql = DB::table('project')->where('u_id', $user->id)->where('status', $type);
            if ($pagesize == 0)
                $projectSql = DB::select("select * from project where u_id = ? and status = ?", [$user->id, $type]);
            else
                $projectSql = DB::select("select * from project where u_id = ? and status = ? limit ?, ?", [$user->id, $type, $pagenum * $pagesize, $pagesize]);
        }
        else
        {
            $countSql = DB::table('project')->where('b_id', $business->b_id)->where('status', $type);
            if ($pagesize == 0)
                $projectSql = DB::select("select * from project where b_id = ? and status = ?", [$business->b_id, $type]);
            else
                $projectSql = DB::select("select * from project where b_id = ? and status = ? limit ?, ?", [$business->b_id, $type, $pagenum * $pagesize, $pagesize]);
        }

        $count = $countSql->count();

        $retval->result = "success";
		$retval->data = new \stdClass();
        $retval->err_msg = "";
        $retval->data->project_count = $count;
        $retval->data->list_count = count($projectSql);
        $retval->data->projects = array();
        foreach($projectSql as $project)
        {
            $tmp = new \stdClass();
            $tmp->project_id = $project->id;
            $tmp->b_id = $project->b_id;
            $tmp->c_id = $project->u_id;
            if ($user->userrole == "customer")
            {
                $tmpbiz = DB::select("select * from business where b_id = ?", [$tmp->b_id])[0];
                $tmp->b_c_name = $tmpbiz->b_title;
                $tmp->b_c_avatar = $tmpbiz->b_image;
            }
            else
            {
                $tmpcus = DB::select("select * from users where id = ?", [$tmp->c_id])[0];
                $tmp->b_c_name = $tmpcus->email;
                $tmp->b_c_avatar = $tmpcus->userprofile;
            }
            $tmp->title = $project->title;
            $tmp->create_at = $project->create_date;
            $tmp->complete_in = $project->delay_day;
            $tmp->price = $project->price;
            $tmp->description = $project->description;
            $tmp->image = $project->image;
            $tmp->status = $project->status;
            $tmp->review = new \stdClass();
            if ($tmp->status == 3)
            {
                $review = DB::table('review')->where('p_id',$project->id)->first();
                $tmp->review->communication_mark = $review->communication;
                $tmp->review->quality_mark = $review->quality;
                $tmp->review->speed_mark = $review->speed;
                $tmp->review->review = $review->review;
            }
            array_push($retval->data->projects, $tmp);
        }

        return response()->json($retval);
    }

    public function getcustomerforproject(Request $request)
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

        $business = DB::select("select * from business where userid = ?", [$user->id])[0];
        $customers = DB::select("  select B.id, B.email from message A
                                    left join users B on A.u_id = B.id
                                    where A.b_id = ?
                                    group by B.id, B.email",[$business->b_id]);

        $retval->result = "success";
        $retval->data = new \stdClass();
        $retval->err_msg = "";
        $retval->data->customer_count = count($customers);
        $retval->data->customers = array();
        foreach($customers as $customer)
        {
            $tmp = new \stdClass();
            $tmp->c_id = $customer->id;
            $tmp->name = $customer->email;

            array_push($retval->data->customers, $tmp);
        }

        return response()->json($retval);
    }

    public function editproject(Request $request)
	{
		$retval = new \stdClass();
		
        $token = $request['token'];
        $project_id = $request['project_id'];
        $c_id = $request['c_id'];
        $title = $request['title'];
        $create_at = $request['create_at'];
        $complete_in = $request['complete_in'];
        $price = $request['price'];
        $description = $request['description'];
        $imagepath = self::fileUpload($request, "image");

        $users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
        }
        $user = $users[0];

        $b_id = DB::table('business')->where('userid',$user->id)->first()->b_id;

        if ($project_id == 0)
        {
            DB::table('project')->insert(['u_id'=>$c_id, 'b_id'=>$b_id, 'title'=>$title, 'description'=>$description, 'image'=>$imagepath,
            'delay_day'=>$complete_in, 'price'=>$price, 'status'=>'0', 'create_date'=>date('Y-m-d H:i:s')]);

            $business = DB::select("select * from business where b_id = ?", [$b_id]);
            $customer = DB::select("select * from users where id = ?", [$c_id]);

            $info = new \stdClass();
            $info->title = $title;
            $info->business = $business[0]->b_title;
            $info->price = $price;
            $info->duration = $complete_in;
            $info->post_date = date('Y-m-d H:i:s');
            /*
            Mail::to($customer[0]->email)->send(
                new mailme("CUSTOMER_RECEIVE_PROJECT", $info));
            */
        }
        else
        {
            if ($imagepath != '')
                DB::update('update project set title = ?, description = ?, image = ?, u_id = ?, delay_day = ?, price = ? WHERE id = ?',[$title, $description, $imagepath, $c_id, $complete_in, $price, $project_id]);
            else
                DB::update('update project set title = ?, description = ?, u_id = ?, delay_day = ?, price = ? WHERE id = ?',[$title, $description, $c_id, $complete_in, $price, $project_id]);
        }

        $retval->result = "success";
		$retval->data = new \stdClass();
        $retval->err_msg = "";
        return response()->json($retval);
    }

    public function delproject(Request $request)
	{
		$retval = new \stdClass();
		
        $token = $request['token'];
        $project_id = $request['project_id'];

        $users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
        }
        $user = $users[0];

        $projects = DB::select("select * from project where id = ?", [$project_id]);
        if (count($projects) == 0)
		{
			$retval->result = "fail";
			$retval->data = array();
			$retval->err_msg = "Invalid Project Id";

			return response()->json($retval);
        }
        else
        {
            DB::delete("delete from project where id = ?", [$project_id]);
        }

        $retval->result = "success";
		$retval->data = new \stdClass();
        $retval->err_msg = "";
        return response()->json($retval);
    }

    public function activeproject(Request $request)
	{
		$retval = new \stdClass();
		
        $token = $request['token'];
        $project_id = $request['project_id'];
        $users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
        }

        DB::update('update project set status = 1 WHERE id = ?',[$project_id]);

        /*
        $projects = DB::select("select * from project where id = ?", [$project_id]);
        
        $info = new \stdClass();
        $info->title = $projects[0]->title;
        $info->customer = Auth::user()->email;
        $info->price = $projects[0]->price;
        $info->duration = $projects[0]->delay_day;
        $info->accept_date = date('Y-m-d H:i:s');

        $business = DB::select("select * from business where b_id = ?", [$projects[0]->b_id]);
        $businessuser = DB::select("select * from users where id = ?", [$business[0]->userid]);

        Mail::to($businessuser[0]->email)->send(
            new mailme("BUSINESS_ACCEPT_PROJECT", $info));
        */

        $retval->result = "success";
		$retval->data = new \stdClass();
        $retval->err_msg = "";
        return response()->json($retval);
    }

    public function completeproject(Request $request)
	{
		$retval = new \stdClass();
		
        $token = $request['token'];
        $project_id = $request['project_id'];
        $users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
        }

        DB::update('update project set status = 2 WHERE id = ?',[$project_id]);

        /*
        $projects = DB::select("select * from project where id = ?", [$project_id]);

        $business = DB::select("select * from business where b_id = ?", [$projects[0]->b_id]);
        $customer = DB::select("select * from users where id = ?", [$projects[0]->u_id]);

        $info = new \stdClass();
        $info->title = $projects[0]->title;
        $info->business = $business[0]->b_title;
        $info->marked_date = date('Y-m-d H:i:s');

        Mail::to($customer[0]->email)->send(
            new mailme("CUSTOMER_COMPLETE_PROJECT", $info));
        */

        $retval->result = "success";
		$retval->data = new \stdClass();
        $retval->err_msg = "";
        return response()->json($retval);
    }

    public function approveproject(Request $request)
	{
		$retval = new \stdClass();
		
        $token = $request['token'];
        $project_id = $request['project_id'];
        $communication_mark = $request['communication_mark'];
        $quality_mark = $request['quality_mark'];
        $speed_mark = $request['speed_mark'];
        $review = $request['review'];

        $users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
        }
        $user = $users[0];

        $project = DB::select("select * from project where id = ?", [$project_id])[0];
        $u_id = $project->u_id;
        $u_avatar = $user->userprofile;
        $b_id = $project->b_id;
        $p_id = $project->id;
        $p_title = $project->title;
        $rating_com = $request['communication_mark'];
        $rating_qlt = $request['quality_mark'];
        $rating_spd = $request['speed_mark'];
        $rating_avg = ($rating_com + $rating_qlt + $rating_spd) / 3;

        DB::table('review')->insert(['u_id'=>$u_id, 'b_id'=>$b_id, 'p_id'=>$p_id, 
        'review'=>$review, 'communication'=>$rating_com, 'quality'=>$rating_qlt, 
        'speed'=>$rating_spd, 'create_date'=>date('Y-m-d H:i:s'),
        'p_title'=>$p_title, 'u_avatar'=>$u_avatar, 'rating'=>$rating_avg]);
        DB::update('update project set status = 3 WHERE id = ?',[$p_id]);
        
/*
        $info = new \stdClass();
        $info->title = $project->title;
        $info->customer = Auth::user()->email;
        $info->complete_date = date('Y-m-d H:i:s');
        $info->rating = $rating_avg;
        $info->review = $review;

        $business = DB::select("select * from business where b_id = ?", [$b_id]);
        $businessuser = DB::select("select * from users where id = ?", [$business[0]->userid]);

        Mail::to($businessuser[0]->email)->send(
            new mailme("BUSINESS_COMPLETE_PROJECT", $info));
*/
        $retval->result = "success";
		$retval->data = new \stdClass();
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