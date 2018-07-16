<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Mail\mailme;
use Illuminate\Support\Facades\Mail;

class MainHomeController extends Controller
{
    public function password_sendemail(Request $request)
    {
        $email = $request['email'];
        $result = "";

        $dbinfos = DB::select("select * from users where email = ?", [$email]);
        if (count($dbinfos) > 0)
        {
            $user = $dbinfos[0];

            $info = new \stdClass();
            $info->newpassword = self::random_password(8);

            $retVal = DB::update("UPDATE users SET password = ? WHERE id = ?", [Hash::make($info->newpassword), $user->id]);

            Mail::to($email)->send(
                new mailme("ADMIN_PASSWORD_RESET", $info));

            $result = "{\"res\":\"true\"}";
        }
        else
        {
            $result = "{\"res\":\"false\",\"errmsg\":\"Email is not exist.\"}";
        }

        print_r($result);
    }

    public function index(){
        
        //$businesses = DB::table('business')->where('bupdate', 'true')->get();

        $businesses = DB::select("select A.* from business A left join users B on A.userid = B.id where B.package = 'premium' and A.status = 1");
        $categories = DB::select("select D.* from (select A.id, COUNT(B.b_id) as cnt from category A
                                    left join business B on A.id = B.b_catid
                                    where B.`status` = 1
                                    GROUP BY A.id
                                    order by cnt desc
                                    limit 0, 6) C
                                    left join category D on C.id = D.id");
        $setting = new \stdClass();
        $setting->homepageimage = DB::table('setting')->where('setting_name','homepageimage')->value('setting_value');
        return view('welcome',array('businesses'=>$businesses, 'categories'=>$categories, 'setting'=>$setting));
    }
    public function contact(){
        $setting = new \stdClass();
        $setting->contactpageimage = DB::table('setting')->where('setting_name','contactpageimage')->value('setting_value');
        $setting->contactus = DB::table('setting')->where('setting_name','contactus')->value('setting_value');
        return view('contact', array('title' => 'Contact to Us', 'setting'=>$setting));
    }
    public function getaboutus(Request $request)
    {
        $retVal = DB::table('setting')->where('setting_name','aboutus')->value('setting_value');
        $result = "{\"data\":\"".$retVal."\"}";
        print_r($result);
    }
    public function getBusiness($id){
        $business = DB::table('business')->where('b_id', $id)->first();
        $business->b_description = preg_replace("/\r\n|\r/", "<br />", $business->b_description);
        $ratings = DB::table('review')->where('b_id', $id)->get();
//        $address = $business->postcode;
//        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false";
//        $json1 = file_get_contents($url);
//        $json = json_decode($json1);
//        var_dump($json);
//        $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
//        $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
        $lat = $business->latitude;
        $long = $business->longitude;
        $mapText = substr($business->b_title,0,2);
        $openhours = explode(',', $business->openinghours);
        $openingResult = [];
        foreach ($openhours as $openhour){
            $catch_open = explode('=', $openhour);
            array_push($openingResult, $catch_open[1]);
        }
        $countReview = 0;
        $avgReview = 0.0;
        $sum = 0;
        foreach($ratings as $rating){
            $countReview ++;
            $sum = $sum + $rating->rating;
        }
        if($countReview != 0){
            $avgReview = round(floatval($sum / $countReview),1);
        }

        DB::update('update business set viewcnt = viewcnt + 1 WHERE b_id = ?',[$id]);
        $updatecnt = DB::update('update businessviewcnt set viewcnt = viewcnt + 1 where b_id = ? and month_col = MONTH(CURRENT_DATE) and year_col = YEAR(CURRENT_DATE)',[$id]);
        if ($updatecnt == 0)
            DB::insert(" insert into `businessviewcnt` (`b_id`, `year_col`, `month_col`, `viewcnt`) values (?, YEAR(CURRENT_DATE), MONTH(CURRENT_DATE), 1)", [$id]);

        return view('businessInfo',array('business'=>$business, 'lat'=>$lat, 'long'=>$long, 'mapText'=>$mapText, 'ratings'=>$ratings, 'openinghours'=>$openingResult,
            'countReview'=>$countReview, 'avgReview'=>$avgReview));
    }
    public function makeconversation(Request $request){
        $businessid = $request['business_id'];
        $content = $request['message_content'];
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

        $content = nl2br($content);
        $content = trim($content);

        $info = new \stdClass();
        $info->customer = Auth::user()->email;
        $info->content = strip_tags($content);
        $info->sent_date = date('Y-m-d H:i:s');

        DB::table('message')->insert(['u_id'=>Auth::user()->id, 'b_id'=>$businessid, 'parent_id'=>'0', 'content'=>$content, 'content_plain'=>strip_tags($content), 'image'=>$filepath, 'direct'=>'0', 'read'=>'0', 'send_date'=>$info->sent_date]);
        $maxids = DB::select("select MAX(id) as maxid from message");
        DB::table('message')->insert(['u_id'=>Auth::user()->id, 'b_id'=>$businessid, 'parent_id'=>$maxids[0]->maxid, 'content'=>$content, 'content_plain'=>strip_tags($content), 'image'=>$filepath, 'direct'=>'0', 'read'=>'0', 'send_date'=>$info->sent_date]);
        
        $business = DB::select("select * from business where b_id = ?", [$businessid]);
        $businessuser = DB::select("select * from users where id = ?", [$business[0]->userid]);

        Mail::to($businessuser[0]->email)->send(
            new mailme("BUSINESS_RECEIVE_NEWMESSAGE", $info));

        return redirect('business/info/'.$businessid);
    }
    public function postcontact(Request $request){
        $name = $request['name'];
        $email = $request['email'];
        $subject = $request['subject'];
        $comments = $request['comments'];
        
        $info = new \stdClass();
        $info->customername = $name;
        $info->customermail = $email;
        $info->subject = $subject;
        $info->comments = $comments;
        $info->sent_date = date('Y-m-d H:i:s');

        DB::table('contactmessage')->insert(['username'=>$name, 'email'=>$email, 'subject'=>$subject, 'message'=>$comments, 'create_at'=>$info->sent_date]);

        Mail::to("info@edenlinx.com")->send(
            new mailme("ADMIN_CONTACT_MESSAGE", $info));
        
        return redirect('/contact');
    }
    public function searchCategroy(Request $request){
        $categoryName = $request->get('categoryName');
        $postalCode = $request->get('postalCode');
        $catid = $request->get('catid');

        if($categoryName ==''){
            $countSql = DB::table('business');
            $businessSql = DB::table('business');
        }else{
            $countSql = DB::table('business')->where('b_keyword', 'like', '%'.$categoryName.'%')
            ->orWhere('b_title','like', '%'.$categoryName.'%')
            ->orWhere('b_description','like', '%'.$categoryName.'%');
            $businessSql = DB::table('business')->where('b_keyword', 'like', '%'.$categoryName.'%')
            ->orWhere('b_title','like', '%'.$categoryName.'%')
            ->orWhere('b_description','like', '%'.$categoryName.'%');
        }

        if($postalCode != ''){
            $countSql = $countSql->where('postcode','like','%'.$postalCode.'%');
            $businessSql = $businessSql->where('postcode','like','%'.$postalCode.'%');
        }

        if ($catid != ''){
            $countSql = $countSql->where('b_catid',$catid);
            $businessSql = $businessSql->where('b_catid',$catid);
        }

        $countSql = $countSql->where('status', '1');
        $businessSql = $businessSql->where('status', '1');

        $count = $countSql->count();
        $business = $businessSql->paginate(20);
        $business->appends('categoryName',$categoryName);
        $business->appends('postalCode',$postalCode);

        return view('category',['business'=>$business, 'totalCount'=>$count,'categoryName'=>$categoryName,'postalCode'=>$postalCode]);
    }

    public function displayCategory(Request $request){
        $business = DB::table('business')->paginate(20);
        $count = DB::table('business')->count();
        return view('category',['business'=>$business, 'totalCount'=>$count]);
    }

    public function categorylist(){
        $categories = DB::table('category')->get();

        return view('categorylist',['categories'=>$categories]);
    }

    public function check_login(Request $request) {
        $email = $request['email'];
        $password = $request['password'];

        $result = new \stdClass();

        $user = DB::table('users')->where('email', $email)->get();
        $result = "";
        
        if (count($user) > 0)
        {
            if (Hash::check($password, $user[0]->password))
            {
                if ($user[0]->status == 1)
                    $result = "{\"res\":\"success\"}";
                else
                    $result = "{\"res\":\"error\", \"status\":\"This is suspended account.\"}";
            }
            else
            {
                $result = "{\"res\":\"error\", \"status\":\"Invalid Email or Password\"}";
            }
        }
        else
        {
            $result = "{\"res\":\"error\", \"status\":\"Invalid Email or Password\"}";
        }
        
        print_r($result);
    }

    public function check_register(Request $request) {
        $name = $request['name'];
        $email = $request['email'];

        $user = DB::table('users')->where('name', $name)->get();
        $result = "";
        
        if (count($user) > 0)
        {
            $result = "{\"res\":\"error\", \"status\":\"Username is already exist\"}";
        }
        else
        {
            $user = DB::table('users')->where('email', $email)->get();

            if (count($user) > 0)
            {
                $result = "{\"res\":\"error\", \"status\":\"Email is already exist\"}";
            }
            else
            {
                $result = "{\"res\":\"success\"}";
            }
        }
        print_r($result);
    }

    public function getnavinfo_customer() {
        $result = "{";
        $result .= "\"res\":\"success\"";
        
        $unreadmessage = DB::select('select count(*) as unreadcnt from message where parent_id <> 0 and u_id = ? and direct = 1 and `read` = 0',[Auth::user()->id]);
        $result .= ",\"unreadmessage\":\"".$unreadmessage[0]->unreadcnt."\"";
        $result .="}";
        
        print_r($result);
    }

    public function getnavinfo_business() {
        $result = "{";
        $result .= "\"res\":\"success\"";

        $business = DB::table('business')->where('userid',Auth::user()->id)->first();
        $unreadmessage = DB::select('select count(*) as unreadcnt from message where parent_id <> 0 and b_id = ? and direct = 0 and `read` = 0',[$business->b_id]);
        $result .= ",\"unreadmessage\":\"".$unreadmessage[0]->unreadcnt."\"";
        $result .="}";
        
        print_r($result);
    }

    function random_password( $length = 8 ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }
}
