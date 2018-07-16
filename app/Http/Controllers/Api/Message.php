<?php

namespace App\Http\Controllers\Api;

use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class Message extends Controller
{
	const DESTINATION_PATH = 'uploads/project';

    public function __construct()
    {

    }

    public function makeconversation(Request $request)
	{
        $retval = new \stdClass();
        
		$token = $request['token'];
        $b_id = $request['b_id'];
        $message = $request['message'];
        $imagepath = Message::fileUpload($request, "image");

        $users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
        }
        $user = $users[0];

        $content = nl2br($message);
        $content = trim($content);

        $info = new \stdClass();
        
        $info->customer = $user->email;
        $info->content = strip_tags($content);
        $info->sent_date = date('Y-m-d H:i:s');
        
        DB::table('message')->insert(['u_id'=>$user->id, 'b_id'=>$b_id, 'parent_id'=>'0', 'content'=>$content, 'content_plain'=>strip_tags($content), 'image'=>$imagepath, 'direct'=>'0', 'read'=>'0', 'send_date'=>$info->sent_date]);
        $maxids = DB::select("select MAX(id) as maxid from message");
        DB::table('message')->insert(['u_id'=>$user->id, 'b_id'=>$b_id, 'parent_id'=>$maxids[0]->maxid, 'content'=>$content, 'content_plain'=>strip_tags($content), 'image'=>$imagepath, 'direct'=>'0', 'read'=>'0', 'send_date'=>$info->sent_date]);
        
        /*
        $business = DB::select("select * from business where b_id = ?", [$b_id]);
        $businessuser = DB::select("select * from users where id = ?", [$business[0]->userid]);
        
        Mail::to($businessuser[0]->email)->send(
            new mailme("BUSINESS_RECEIVE_NEWMESSAGE", $info));
        */

        $retval->result = "success";
		$retval->data = new \stdClass();
        $retval->err_msg = "";
        return response()->json($retval);
    }

    public function conversationlist(Request $request)
    {
        $retval = new \stdClass();
        
        $token = $request['token'];
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

        $id = $user->id;
        $perPage = $pagesize;
        $curPage = $pagenum;
        $business = DB::select("select * from business where userid = ?",[$id]);
        $bid = 0;
        if (count($business) > 0)
            $bid = $business[0]->b_id;
        
        if ($user->userrole == "business")
            $countSql = DB::select('select count(id) as totalcnt from message where parent_id = 0 and b_id = ?',[$bid]);
        else
            $countSql = DB::select('select count(id) as totalcnt from message where parent_id = 0 and u_id = ?',[$id]);

        if ($perPage > 0)
        {
            if ($user->userrole == "business")
            {
                $messageSql = DB::select(  'select A.*, B.name, B.userprofile from message A
                                            left join users B on A.u_id = B.id
                                            where A.b_id = ? and A.parent_id = 0 
                                            order by A.send_date desc
                                            limit ?, ?'
                                            ,[$bid, $curPage * $perPage, $perPage]);
            }
            else
            {
                $messageSql = DB::select(  'select A.*, B.b_title as name, B.b_image as userprofile from message A
                                            left join business B on A.b_id = B.b_id
                                            where A.u_id = ? and A.parent_id = 0 
                                            order by A.send_date desc
                                            limit ?, ?'
                                            ,[$id, $curPage * $perPage, $perPage]);
            }
        }
        else
        {
            if ($user->userrole == "business")
            {
                $messageSql = DB::select(  'select A.*, B.name, B.userprofile from message A
                                            left join users B on A.u_id = B.id
                                            where A.b_id = ? and A.parent_id = 0 
                                            order by A.send_date desc'
                                            ,[$bid]);
            }
            else
            {
                $messageSql = DB::select(  'select A.*, B.b_title as name, B.b_image as userprofile from message A
                                            left join business B on A.b_id = B.b_id
                                            where A.u_id = ? and A.parent_id = 0 
                                            order by A.send_date desc'
                                            ,[$id]);
            }
        }
        
        $count = count($countSql) > 0 ? $countSql[0]->totalcnt : 0;

        $retval->result = "success";
        $retval->data = new \stdClass();
        $retval->err_msg = "";
        $retval->data->conversation_count = $count;
        $retval->data->list_count = count($messageSql);
        $retval->data->conversations = array();
        foreach($messageSql as $message)
        {
            $tmp = new \stdClass();
            $tmp->conv_id = $message->id;
            $tmp->avatar = $message->userprofile;
            $tmp->name = $message->name;
            $tmp->lastmessage = $message->content_plain;
            $tmp->lastmessage_date = $message->send_date;
            $tmp->unread = ($message->direct == 0 && $message->read == 0) ? 1 : 0;

            array_push($retval->data->conversations, $tmp);
        }

        return response()->json($retval);
    }

    public function getmessagelist(Request $request)
    {
        $retval = new \stdClass();
        
        $token = $request['token'];
        $conv_id = $request['conv_id'];

        $users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
        }
        $user = $users[0];

        $u_id = $user->id;

        $messages = DB::select("select * from message where parent_id = ? order by send_date asc", [$conv_id]);
        $businessname = $businessprofile = "";
        if (count($messages) > 0)
        {
            $b_id = $messages[0]->b_id;
            $business = DB::select("select * from business where b_id = ?",[$b_id]);
            if (count($business) > 0)
            {
                $businessname = $business[0]->b_title;
                $businessprofile = $business[0]->b_image;
            }

            $c_id = $messages[0]->u_id;
            $customer = DB::select("select name, userprofile from users where id = ?",[$c_id]);
            $customername = $customerprofile = "";
            if (count($customer) > 0)
            {
                $customername = $customer[0]->name;
                $customerprofile = $customer[0]->userprofile;
            }
        }
        else
        {
            $retval->result = "fail";
            $retval->data = new \stdClass();
            $retval->err_msg = "Wrong conversation id";
            return response()->json($retval);
        }
        DB::update('update message set message.read = 1 WHERE (id = ? or parent_id = ?) and direct = 1',[$conv_id, $conv_id]);

        $retval->result = "success";
        $retval->data = new \stdClass();
        $retval->err_msg = "";
        $retval->data->message_count = count($messages);
        $retval->data->b_id = $b_id;
        $retval->data->c_id = $c_id;
        $retval->data->business_avatar = $businessprofile;
        $retval->data->business_name = $businessname;
        $retval->data->customer_avatar = $customerprofile;
        $retval->data->customer_name = $customername;
        $retval->data->messages = array();
        foreach($messages as $message)
        {
            $tmp = new \stdClass();
            $tmp->message_id = $message->id;
            $tmp->message = $message->content;
            $tmp->image = $message->image;
            $tmp->direct = $message->direct;

            array_push($retval->data->messages, $tmp);
        }

        return response()->json($retval);
    }

    public function sendmessage(Request $request){
        $retval = new \stdClass();
        
        $token = $request['token'];
        $conv_id = $request['conv_id'];
        $content = $request['message'];
        $imagepath = Message::fileUpload($request, "image");

        $users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
        }
        $user = $users[0];

        $content_plain = strip_tags($content);

        $messages = DB::select("select * from message where id = ?", [$conv_id]);
        $b_id = $messages[0]->b_id;
        $business = DB::select("select * from business where b_id = ?",[$b_id]);
        if (count($business) > 0)
        {
            $businessname = $business[0]->b_title;
            $businessprofile = $business[0]->b_image;
        }

        $c_id = $messages[0]->u_id;
        $customer = DB::select("select name, userprofile from users where id = ?",[$c_id]);
        $customername = $customerprofile = "";
        if (count($customer) > 0)
        {
            $customername = $customer[0]->name;
            $customerprofile = $customer[0]->userprofile;
        }

        $info = new \stdClass();
        $info->customer = $user->email;
        $info->content = $content_plain;
        $info->sent_date = date('Y-m-d H:i:s');

        if ($user->userrole == "customer")
        {
            DB::table('message')->insert(['u_id'=>$c_id, 'b_id'=>$b_id, 'parent_id'=>$conv_id, 'content'=>$content, 'content_plain'=>$content_plain, 'image'=>$imagepath, 'direct'=>'0', 'read'=>'0', 'send_date'=>$info->sent_date]);
            DB::update("update message set content = ?, content_plain = ?, direct = 0, `read` = 0, send_date = ? where id = ?",[$content, $content_plain, $info->sent_date, $conv_id]);
        }
        else
        {
            DB::table('message')->insert(['u_id'=>$c_id, 'b_id'=>$b_id, 'parent_id'=>$conv_id, 'content'=>$content, 'content_plain'=>$content_plain, 'image'=>$imagepath, 'direct'=>'1', 'read'=>'0', 'send_date'=>$info->sent_date]);
            DB::update("update message set content = ?, content_plain = ?, direct = 1, `read` = 0, send_date = ? where id = ?",[$content, $content_plain, $info->sent_date, $conv_id]);
        }
        /*
        $business = DB::select("select * from business where b_id = ?", [$b_id]);
        $businessuser = DB::select("select * from users where id = ?", [$business[0]->userid]);
        Mail::to($businessuser[0]->email)->send(
            new mailme("BUSINESS_RECEIVE_NEWMESSAGE", $info));
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