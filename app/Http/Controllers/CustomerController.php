<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use App\Mail\mailme;
use Illuminate\Support\Facades\Mail;

class CustomerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $package = DB::table('users')->where('id',Auth::id())->value('package');
        return redirect('/customer/profile');
    }
    public function profile(){
        $id = Auth::user()->id;
        $userdata = DB::select('select * from users WHERE id = ?',[$id]);
        $name = $userdata[0] -> name;
        $phone = $userdata[0] -> userphone;
        $email = $userdata[0] -> email;
        $notes = $userdata[0] -> notes;
        $profileImage = $userdata[0] -> userprofile;

        return view('customerpage/profile', array('title' => 'My Profile', 'profileImage' => $profileImage, 'name' => $name, 'phone' => $phone, 'email' => $email,
            'notes' => $notes, 'profileImage' => $profileImage));
    }
    public function saveprofile(Request $request){
        $file = $request->file('profile_image');
        if(isset($file)){
            $extention = $file->getClientOriginalExtension();
            $filename = Auth::user()->email.'_'.date('His').'.'.$extention;
            $destinationPath = 'uploads/profile';
            $file->move($destinationPath, $filename);
            $filepath = $destinationPath.'/'.$filename;
        }
        else{
            $filepath = '';
        }
        $name = $request['name'];
        $phone = $request['phone'];
        $email = $request['email'];
        $notes = $request['notes'];
        $id = Auth::user()->id;

        if ($filepath != '')
            DB::update('update users set name = ?, userphone = ?, email = ?, notes = ?, userprofile = ? WHERE id = ?',[$name, $phone, $email, $notes, $filepath, $id]);
        else
            DB::update('update users set name = ?, userphone = ?, email = ?, notes = ? WHERE id = ?',[$name, $phone, $email, $notes, $id]);
        return redirect('customer/profile');
    }
    public function resetprofile(Request $request){
        $old_pwd = $request['oldpwd'];
        if(!Hash::check($old_pwd, Auth::user()->getAuthPassword())){
            return redirect('customer/profile')->with('oldpwd', 'false');
        }
        else{
            $this->validate($request,[
//            'oldpwd'=>'exists:users,password',
                'newpwd'=>'confirmed'
            ]);
            $newpassword =  Hash::make($request['newpwd']);
            DB::update('update users set password = ? WHERE id = ?',[$newpassword, Auth::id()]);
            return redirect('customer/profile')->with(['success'=>'Reset password successfully'])->withInput();
        }
    }
    public function dashboard(){
        return redirect('/customer/profile');
        //return view('customerpage/dashboard', array('title' => 'Dashboard'));
    }

    public function package(){
        $package = DB::table('users')->where('id',Auth::id())->value('package');
        return view('customerpage/packages', ['title'=>'Listing Packages', 'package'=>$package]);
    }
    public function setpackage($name){
        var_dump($name);
        DB::update('update users set package = ? where id = ?',[$name, Auth::id()]);
        return redirect('/customer/packages');
    }
    public function message(Request $request){
        $id = Auth::user()->id;
        $perPage = 5;
        $curPage = ($request['page']==null? 1 : $request['page']);
                
        $countSql = DB::select('select count(id) as totalcnt from message where parent_id = 0 and u_id = ?',[$id]);
        $messageSql = DB::select(  'select A.*, B.b_title, B.b_image from message A
                                    left join business B on A.b_id = B.b_id
                                    where A.u_id = ? and A.parent_id = 0 
                                    order by A.send_date desc
                                    limit ?, ?'
                                    ,[$id, ($curPage - 1) * $perPage, $perPage]);

        $count = count($countSql) > 0 ? $countSql[0]->totalcnt : 0;

        return view('/customerpage/message',['title'=>'Messages', 'messages'=>$messageSql, 'totalCount'=>$count, 'curPage'=>$curPage, 'perPage'=>$perPage]);
    }
    public function messagedetail($conv_id){
        $u_id = Auth::user()->id;
        $user = DB::select("select name, userprofile from users where id = ?",[$u_id]);
        $customername = $customerprofile = "";
        if (count($user) > 0)
        {
            $customername = $user[0]->name;
            $customerprofile = $user[0]->userprofile;
        }
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
        }
        DB::update('update message set message.read = 1 WHERE (id = ? or parent_id = ?) and direct = 1',[$conv_id, $conv_id]);
        return view('/customerpage/messagedetail',['title'=>'Message', 'messages'=>$messages, 'customername'=>$customername, 'customeravatar'=>$customerprofile, 'businessname'=>$businessname, 'businessavatar'=>$businessprofile]);
    }
    public function sendmessage(Request $request){
        $b_id = $request['b_id'];
        $parent_id = $request['parent_id'];
        $content = $request['message_content'];
        $content_plain = strip_tags($content);
        $file = $request->file('project_image');
        if(isset($file)){
            $extention = $file->getClientOriginalExtension();
            $filename = basename($file->path()).'_'.date('His').'.'.$extention;
            $destinationPath = 'uploads/project';
            $file->move($destinationPath, $filename);
            $filepath = $destinationPath.'/'.$filename;
        }
        else{
            $filepath = '';
        }

        $uid = Auth::user()->id;

        $info = new \stdClass();
        $info->customer = Auth::user()->email;
        $info->content = $content_plain;
        $info->sent_date = date('Y-m-d H:i:s');

        DB::table('message')->insert(['u_id'=>$uid, 'b_id'=>$b_id, 'parent_id'=>$parent_id, 'content'=>$content, 'content_plain'=>$content_plain, 'image'=>$filepath, 'direct'=>'0', 'read'=>'0', 'send_date'=>$info->sent_date]);
        DB::update("update message set content = ?, content_plain = ?, direct = 0, `read` = 0, send_date = ? where id = ?",[$content, $content_plain, $info->sent_date, $parent_id]);
        $business = DB::select("select * from business where b_id = ?", [$b_id]);
        $businessuser = DB::select("select * from users where id = ?", [$business[0]->userid]);

        Mail::to($businessuser[0]->email)->send(
            new mailme("BUSINESS_RECEIVE_NEWMESSAGE", $info));

        return redirect('/customer/message/'.$parent_id);
    }
    public function projects($status){
        $u_id = Auth::user()->id;

        $countSql = DB::table('project')->where('u_id', $u_id)->where('status', $status);
        $projectSql = DB::table('project')->where('u_id', $u_id)->where('status', $status);

        $count = $countSql->count();
        $projects = $projectSql->paginate(4);

        foreach($projects as $project)
        {
            $project->business = DB::table('business')->where('b_id',$project->b_id)->first();
            if ($status == 3)
            {
                $project->review = DB::table('review')->where('p_id',$project->id)->first();
            }
        }

        return view('/customerpage/projects',['title'=>'Projects', 'status'=>$status, 'projects'=>$projects, 'totalCount'=>$count]);
    }
    public function projectaccept($edit_id){
        DB::update('update project set status = 1 WHERE id = ?',[$edit_id]);
        $projects = DB::select("select * from project where id = ?", [$edit_id]);

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

        return redirect('customer/projects/1');
    }
    public function projectcomplete(Request $request){
        $u_id = Auth::user()->id;
        $u_avatar = DB::table('users')->where('id',$u_id)->first()->userprofile;
        $b_id = $request["b_id"];
        $p_id = $request["p_id"];
        $p_title = $request["p_title"];
        $review = $request["review"];
        $rating_com = $request["com_rating_".$p_id] != null ? $request["com_rating_".$p_id] : 0;
        $rating_qlt = $request["qlt_rating_".$p_id] != null ? $request["qlt_rating_".$p_id] : 0;
        $rating_spd = $request["spd_rating_".$p_id] != null ? $request["spd_rating_".$p_id] : 0;
        $rating_avg = ($rating_com + $rating_qlt + $rating_spd) / 3;

        DB::table('review')->insert(['u_id'=>$u_id, 'b_id'=>$b_id, 'p_id'=>$p_id, 
        'review'=>$review, 'communication'=>$rating_com, 'quality'=>$rating_qlt, 
        'speed'=>$rating_spd, 'create_date'=>date('Y-m-d H:i:s'),
        'p_title'=>$p_title, 'u_avatar'=>$u_avatar, 'rating'=>$rating_avg]);
        DB::update('update project set status = 3 WHERE id = ?',[$p_id]);

        $projects = DB::select("select * from project where id = ?", [$p_id]);

        $info = new \stdClass();
        $info->title = $projects[0]->title;
        $info->customer = Auth::user()->email;
        $info->complete_date = date('Y-m-d H:i:s');
        $info->rating = $rating_avg;
        $info->review = $review;

        $business = DB::select("select * from business where b_id = ?", [$b_id]);
        $businessuser = DB::select("select * from users where id = ?", [$business[0]->userid]);

        Mail::to($businessuser[0]->email)->send(
            new mailme("BUSINESS_COMPLETE_PROJECT", $info));

        return redirect('customer/projects/3');
    }
}
