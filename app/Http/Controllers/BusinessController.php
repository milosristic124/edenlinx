<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Mail\mailme;
use Illuminate\Support\Facades\Mail;

class BusinessController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return redirect('business/dashboard');
    }
    public function business()
    {
        $package = DB::table('users')->where('id',Auth::id())->value('package');
        $categories = DB::select("select * from category order by categoryname");
        $res1 = DB::table('business')->where('userid',Auth::id())->first();
        $b_check = 'false';
        if(!isset($res1->postcode)){
            $b_check = 'true';
        }
        /*
        if($res1 == null){
            $b_check = 'true';
            DB::table('business')->insert(['userid'=>Auth::id(), 'b_title'=>'Default Business', 'b_category'=>'Default Category', 'b_keyword'=>'Default',
                'b_image'=>'https://placehold.it/468x265?text=IMAGE', 'b_headerimage'=>'https://placehold.it/1200x400?text=IMAGE']);
            $res1 = DB::table('business')->where('userid',Auth::id())->first();
        }
        */
        return view('businesspage/business', array('title' => 'Business Listing', 'package'=>$package, 'b_res'=>$res1, 'b_check'=>$b_check, 'categories'=>$categories));
    }
    public function savebusiness(Request $request){
        $destinationPath = 'uploads/business';
        $res = DB::table('business')->where('userid',Auth::id())->first();
        if($request->file('business-main-img') != null){
            $file_main = $request->file('business-main-img');
            $extention_main = $file_main->getClientOriginalExtension();
            $filename_main = Auth::user()->email.'_main_'.date('His').'.'.$extention_main;
            //$file_main->move($destinationPath, $filename_main);
            $filepath_main = $destinationPath.'/'.$filename_main;
            $imgdata = $request['imgData'];
            $imgdata = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgdata));
            file_put_contents($filepath_main, $imgdata);
        }elseif($res->b_image != null){
            $filepath_main = $res->b_image;
        }else{
            $filepath_main = "https://placehold.it/468x265?text=IMAGE";
        }
        if($request->file('business-listing-img') != null){
            $file_listing = $request->file('business-listing-img');
            $extention_listing = $file_listing->getClientOriginalExtension();
            $filename_listing = Auth::user()->email.'_listing_'.date('His').'.'.$extention_listing;
//            $file_listing->move($destinationPath, $filename_listing);
            $filepath_listing = $destinationPath.'/'.$filename_listing;
            $imgdata1 = $request['imgData1'];
            $imgdata1 = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgdata1));
            file_put_contents($filepath_listing, $imgdata1);
        }elseif($res->b_headerimage != null){
            $filepath_listing = $res->b_headerimage;
        }else{
            $filepath_listing = "https://placehold.it/1200x400?text=IMAGE";
        }

        $openinghours = '';
        if($request->has($request['o_moday'])){
            $input = array('o_mon'=>$request['o_monday'],'c_mon'=>$request['c_monday'],'o_tue'=>$request['o_tuesday'],'c_tue'=>$request['c_tuesday'],
                'o_wed'=>$request['o_wednesday'],'c_wed'=>$request['c_wednesday'],'o_thu'=>$request['o_thursday'],'c_thu'=>$request['c_thursday'],
                'o_fri'=>$request['o_friday'],'c_fri'=>$request['c_friday'],'o_sat'=>$request['o_saturday'],'c_sat'=>$request['c_saturday'],
                'o_sun'=>$request['o_sunday'],'c_sun'=>$request['c_sunday']);
            $openinghours = implode(', ', array_map(
                function ($v, $k) {
                    if(is_array($v)){
                        return $k.'[]='.implode('&'.$k.'[]=', $v);
                    }else{
                        return $k.'='.$v;
                    }
                },
                $input,
                array_keys($input)
            ));
        }
        // $address = $request['business_zipcode'];
        // $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($address)."&sensor=false";
        // $json1 = file_get_contents($url);
        // $json = json_decode($json1);

//        var_dump($json);
        // $lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
        // $long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
        $str1 = $request['business_address'];
        $str2 = $request['business_city'];
        $str3 = $request['business_state'];
        $str_res = $str1.' '.$str2.' '.$str3;
        $location = str_replace(' ', '+', $str_res);
        $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.$location.'&sensor=false');
        $geo = json_decode($geo, true);
        if ($geo['status'] == 'OK') {
            // Get Lat & Long
            $lat = $geo['results'][0]['geometry']['location']['lat'];
            $long = $geo['results'][0]['geometry']['location']['lng'];
        }else{
            $lat = -33.8063202;
            $long = 151.0055087;
        }
        $categorynames = DB::select("select categoryname from category where id = ?", [$request['business_category']]);
        $categoryname = "";
        if (count($categorynames) > 0)
            $categoryname = $categorynames[0]->categoryname;
        DB::update('update business set b_title = ?, b_catid = ?, b_category = ?, b_keyword = ?, state = ?, city = ?, address = ?, postcode = ?,
            b_image = ?, b_headerimage = ?, b_description = ?, b_phone = ?, b_website = ?, b_email = ?, openinghours = ?, latitude = ?, longitude = ?, bupdate = ? WHERE userid = ?', [$request['business_title'],
            $request['business_category'], $categoryname, $request['business_keywords'], $request['business_state'], $request['business_city'], $request['business_address'], $request['business_zipcode'],
            $filepath_main, $filepath_listing, $request['business_description'], $request['business_phone'], $request['business_website'], $request['business_email'], $openinghours,
            $lat, $long, 'false', Auth::id()]);
//        var_dump($lat, $long);
//        var_dump(explode(',', $openinghours));
//        DB::table('business')->insert(['userid'=>Auth::id(),'b_title'=>$request['business_title'],'b_category'=>$request['business_category'],
//            'b_keyword'=>$request['business_keywords'],'state'=>$request['business_state'],'city'=>$request['business_city'],'address'=>$request['business_address'],
//            'postcode'=>$request['business_zipcode'],'b_image'=>$filepath,'b_description'=>$request['business_description'],
//            'b_phone'=>$request['business_phone'],'b_website'=>$request['business_website'],'b_email'=>$request['business_email'],'openinghours'=>$openinghours,
//            'latitude'=>$lat,'longitude'=>$long,'update'=>'false']);
        return redirect('business/business');
    }
    public function professionalheader(){
        
        return view('businesspage/professionalheader', array('title' => 'Business Listing'));
    }
    public function saveprofessionalheader(Request $request){
        $file1 = $request->file('professional_image1');
        if(isset($file1)){
            $extention = $file1->getClientOriginalExtension();
            $filename = Auth::user()->email.'_professional1_'.date('His').'.'.$extention;
            $destinationPath = 'uploads/business';
            $file1->move($destinationPath, $filename);
            $filepath1 = $destinationPath.'/'.$filename;
        }
        else{
            $filepath1 = '';
        }

        $file2 = $request->file('professional_image2');
        if(isset($file2)){
            $extention = $file2->getClientOriginalExtension();
            $filename = Auth::user()->email.'_professional2_'.date('His').'.'.$extention;
            $destinationPath = 'uploads/business';
            $file2->move($destinationPath, $filename);
            $filepath2 = $destinationPath.'/'.$filename;
        }
        else{
            $filepath2 = '';
        }

        $file3 = $request->file('professional_image3');
        if(isset($file3)){
            $extention = $file3->getClientOriginalExtension();
            $filename = Auth::user()->email.'_professional3_'.date('His').'.'.$extention;
            $destinationPath = 'uploads/business';
            $file3->move($destinationPath, $filename);
            $filepath3 = $destinationPath.'/'.$filename;
        }
        else{
            $filepath3 = '';
        }

        $business = DB::select('select * from business WHERE userid = ?',[Auth::user()->id]);

        DB::table('professionalheader')->insert(['b_id'=>$business[0]->b_id, 'image1'=>$filepath1, 'image2'=>$filepath2, 'image3'=>$filepath3, 'description'=>$request['description'], 'create_at'=>date('Y-m-d H:i:s')]);

        return redirect('business/business');
    }
    public function profile(){
        $id = Auth::user()->id;
        $userdata = DB::select('select * from users WHERE id = ?',[$id]);
        $name = $userdata[0] -> name;
        $phone = $userdata[0] -> userphone;
        $email = $userdata[0] -> email;
        $notes = $userdata[0] -> notes;
        $profileImage = $userdata[0] -> userprofile;

        return view('businesspage/profile', array('title' => 'My Profile', 'profileImage' => $profileImage, 'name' => $name, 'phone' => $phone, 'email' => $email,
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
        return redirect('business/profile');
    }
    public function resetprofile(Request $request){
        $old_pwd = $request['oldpwd'];
        if(!Hash::check($old_pwd, Auth::user()->getAuthPassword())){
            return redirect('business/profile')->with('oldpwd', 'false');
        }
        else{
            $this->validate($request,[
//            'oldpwd'=>'exists:users,password',
                'newpwd'=>'confirmed'
            ]);
            $newpassword =  Hash::make($request['newpwd']);
            DB::update('update users set password = ? WHERE id = ?',[$newpassword, Auth::id()]);
            return redirect('business/profile')->with(['success'=>'Reset password successfully'])->withInput();
        }
    }
    public function dashboard(){
        $info = new \stdClass();
        $user = DB::select("select * from users where id = ?", [Auth::id()])[0];
        $business = DB::table('business')->where('userid',Auth::id())->first();
        if($business == null){
            DB::table('business')->insert(['userid'=>Auth::id(), 'b_title'=>'Default Business', 'b_category'=>'Default Category', 'b_keyword'=>'Default',
                'b_image'=>'https://placehold.it/468x265?text=IMAGE', 'b_headerimage'=>'https://placehold.it/1200x400?text=IMAGE']);
            $business = DB::table('business')->where('userid',Auth::id())->first();
        }

        $temp = DB::select("select count(id) as activeproject from project where b_id = ? and status = 1", [$business->b_id]);
        if (count($temp) == 0 && $temp[0]->activeproject == null)
            $info->activeproject = 0;
        else
            $info->activeproject = $temp[0]->activeproject;

        $temp = DB::select("select count(price) as completeproject from project where b_id = ? and status = 3 and month(create_date) = month(current_date()) and year(create_date) = year(current_date())", [$business->b_id]);
        if (count($temp) == 0 && $temp[0]->monthlysale == null)
            $info->completeproject = 0;
        else
            $info->completeproject = $temp[0]->completeproject;

        $temp = DB::select("select sum(price) as monthlysale from project where b_id = ? and status = 3 and month(create_date) = month(current_date()) and year(create_date) = year(current_date())", [$business->b_id]);
        if (count($temp) == 0 && $temp[0]->monthlysale == null)
            $info->monthlysale = 0;
        else
            $info->monthlysale = $temp[0]->monthlysale;

        $temp = DB::select("select sum(price) as totalsale from project where b_id = ? and status = 3", [$business->b_id]);
        if (count($temp) == 0 && $temp[0]->totalsale == null)
            $info->totalsale = 0;
        else
            $info->totalsale = $temp[0]->totalsale;

        $info->viewcnt = array();
        for($i = 0; $i < 6; $i++)
        {
            $temp = DB::select("select * FROM businessviewcnt WHERE year_col = YEAR(CURRENT_DATE - INTERVAL ".$i." MONTH) AND month_col = MONTH(CURRENT_DATE - INTERVAL ".$i." MONTH) AND b_id = ?", [$business->b_id]);
            if (count($temp) == 0)
                array_push($info->viewcnt, 0);
            else
                array_push($info->viewcnt, $temp[0]->viewcnt);
        }

        $temp = DB::select("select A.id, A.title, A.image, B.email, (SELECT DATE_ADD(create_date, INTERVAL delay_day DAY)) as enddate from project A
                            left join users B on A.u_id = B.id
                            where A.b_id = ? and A.status = 1
                            order by enddate asc limit 0, 5", [$business->b_id]);
        $info->nextproject = $temp;

        return view('businesspage/dashboard', array('title' => 'Dashboard', 'info' => $info));
    }
    public function package(){
        $packageprice = new \stdClass();
        $packageprice->free = DB::table('packageprice')->where('packagename','free')->value('price');
        $packageprice->basic = DB::table('packageprice')->where('packagename','basic')->value('price');
        $packageprice->regular = DB::table('packageprice')->where('packagename','regular')->value('price');
        $packageprice->premium = DB::table('packageprice')->where('packagename','premium')->value('price');
        $package = DB::table('users')->where('id',Auth::id())->value('package');
        $couponcode = DB::table('business')->where('userid',Auth::id())->value('couponcode');
        $salesstaff = DB::select("select * from salesstaff where couponcode = ?", [$couponcode]);
        
        if (count($salesstaff) > 0)
        {
            $type = $salesstaff[0]->discounttype;
            $price = $salesstaff[0]->discountprice;
            if ($type == 0)
            {
                $packageprice->free = $packageprice->free / 100 * (100 - $price);
                $packageprice->basic = $packageprice->basic / 100 * (100 - $price);
                $packageprice->regular = $packageprice->regular / 100 * (100 - $price);
                $packageprice->premium = $packageprice->premium / 100 * (100 - $price);
            }
            else
            {
                $packageprice->free = $packageprice->free - $price;
                $packageprice->basic = $packageprice->basic - $price;
                $packageprice->regular = $packageprice->regular - $price;
                $packageprice->premium = $packageprice->premium - $price;

                if ($packageprice->free < 0) $packageprice->free = 0;
                if ($packageprice->basic < 0) $packageprice->basic = 0;
                if ($packageprice->regular < 0) $packageprice->regular = 0;
                if ($packageprice->premium < 0) $packageprice->premium = 0;
            }
        }
        return view('businesspage/packages', ['title'=>'Listing Packages', 'packageprice'=>$packageprice, 'package'=>$package, 'couponcode'=>$couponcode, 'salesstaff'=>$salesstaff]);
    }
    public function setpackage($name){
        var_dump($name);
        DB::update('update users set package = ? where id = ?',[$name, Auth::id()]);
        return redirect('/business/packages');
    }
    public function checkcouponcode(Request $request){
        $couponcode = $request['couponcode'];

        if ($couponcode == "")
        {
            DB::update("update business set couponcode = '' where userid = ?",[Auth::id()]);
            $result = "{\"res\":\"true\"}";
        }
        else
        {
            $retVal = DB::select("select * from salesstaff where couponcode = ?", [$couponcode]);
            $result = "";
            if (count($retVal) > 0)
            {
                DB::update("update business set couponcode = ? where userid = ?",[$couponcode, Auth::id()]);
                $result = "{\"res\":\"true\"}";
            }
            else
            {
                $result = "{\"res\":\"false\"}";
            }
        }
        print_r($result);
    }
    public function projects($status){
        $id = Auth::user()->id;
        $business = DB::select("select * from business where userid = ?",[$id]);
        $b_id = 0;
        if (count($business) > 0)
            $b_id = $business[0]->b_id;

        $countSql = DB::table('project')->where('b_id', $b_id)->where('status', $status);
        $projectSql = DB::table('project')->where('b_id', $b_id)->where('status', $status);

        $count = $countSql->count();
        $projects = $projectSql->paginate(4);

        foreach($projects as $project)
        {
            $project->customer = DB::table('users')->where('id',$project->u_id)->first();
            if ($status == 3)
            {
                $project->review = DB::table('review')->where('p_id',$project->id)->first();
            }
        }

        return view('/businesspage/projects',['title'=>'Projects', 'status'=>$status, 'projects'=>$projects, 'totalCount'=>$count]);
    }
    public function projectedit($edit_id){
        $projects = DB::select('select * from project WHERE id = ?',[$edit_id]);
        $project = new \stdClass();
        if (count($projects) == 0)
        {
            $res1 = DB::table('business')->where('userid',Auth::user()->id)->first();

            $project->id = 0;
            $project->b_id = $res1->b_id;
        }
        else
            $project = $projects[0];

        $business = DB::select("select * from business where userid = ?",[Auth::user()->id]);
        $b_id = 0;
        $customers = array();
        if (count($business) > 0)
        {
            $b_id = $business[0]->b_id;
            $customers = DB::select("  select B.id, B.email from message A
                                        left join users B on A.u_id = B.id
                                        where A.b_id = ?
                                        group by B.id, B.email",[$b_id]);

        }
        return view('/businesspage/projectedit',['title'=>'Projects', 'status'=>'0', 'customers'=>$customers, 'project'=>$project]);
    }
    public function saveproject(Request $request){
        $editid = $request["edit_id"];
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
        
        $u_id = $request["u_id"];
        $b_id = DB::table('business')->where('userid',Auth::user()->id)->first()->b_id;
        $title = $request['title'];
        $description = $request['description'];
        $delay_day = $request['delay_day'];
        $price = $request['price'];

        if ($editid == 0)
        {
            DB::table('project')->insert(['u_id'=>$u_id, 'b_id'=>$b_id, 'title'=>$title, 'description'=>$description, 'image'=>$filepath,
            'delay_day'=>$delay_day, 'price'=>$price, 'status'=>'0', 'create_date'=>date('Y-m-d H:i:s')]);

            $business = DB::select("select * from business where b_id = ?", [$b_id]);
            $customer = DB::select("select * from users where id = ?", [$u_id]);

            $info = new \stdClass();
            $info->title = $title;
            $info->business = $business[0]->b_title;
            $info->price = $price;
            $info->duration = $delay_day;
            $info->post_date = date('Y-m-d H:i:s');
    
            Mail::to($customer[0]->email)->send(
                new mailme("CUSTOMER_RECEIVE_PROJECT", $info));
        }
        else
        {
            if ($filepath != '')
                DB::update('update project set title = ?, description = ?, image = ?, u_id = ?, delay_day = ?, price = ? WHERE id = ?',[$title, $description, $filepath, $u_id, $delay_day, $price, $editid]);
            else
                DB::update('update project set title = ?, description = ?, u_id = ?, delay_day = ?, price = ? WHERE id = ?',[$title, $description, $u_id, $delay_day, $price, $editid]);
        }
    
        return redirect('business/projects/0');
    }
    public function projectdel($edit_id){
        $projects = DB::delete('delete from project WHERE id = ?',[$edit_id]);
        return redirect('business/projects/0');
    }
    public function projectpending($edit_id){
        DB::update('update project set status = 2 WHERE id = ?',[$edit_id]);
        $projects = DB::select("select * from project where id = ?", [$edit_id]);

        $business = DB::select("select * from business where b_id = ?", [$projects[0]->b_id]);
        $customer = DB::select("select * from users where id = ?", [$projects[0]->u_id]);

        $info = new \stdClass();
        $info->title = $projects[0]->title;
        $info->business = $business[0]->b_title;
        $info->marked_date = date('Y-m-d H:i:s');

        Mail::to($customer[0]->email)->send(
            new mailme("CUSTOMER_COMPLETE_PROJECT", $info));

        return redirect('business/projects/2');
    }
    public function message(Request $request){
        $id = Auth::user()->id;
        $perPage = 5;
        $curPage = ($request['page']==null? 1 : $request['page']);
        $business = DB::select("select * from business where userid = ?",[$id]);
        $bid = 0;
        if (count($business) > 0)
            $bid = $business[0]->b_id;
                
        $countSql = DB::select('select count(id) as totalcnt from message where parent_id = 0 and b_id = ?',[$bid]);
        $messageSql = DB::select(  'select A.*, B.name, B.userprofile from message A
                                    left join users B on A.u_id = B.id
                                    where A.b_id = ? and A.parent_id = 0 
                                    order by A.send_date desc
                                    limit ?, ?
                                    ',[$bid, ($curPage - 1) * $perPage, $perPage]);

        $count = count($countSql) > 0 ? $countSql[0]->totalcnt : 0;

        return view('/businesspage/message',['title'=>'Messages', 'messages'=>$messageSql, 'totalCount'=>$count, 'curPage'=>$curPage, 'perPage'=>$perPage]);
    }
    public function messagedetail($conv_id){
        $u_id = Auth::user()->id;
        $business = DB::select("select * from business where userid = ?",[$u_id]);
        $businessname = $businessprofile = "";
        if (count($business) > 0)
        {
            $business = DB::select("select * from business where b_id = ?",[$business[0]->b_id]);
            if (count($business) > 0)
            {
                $businessname = $business[0]->b_title;
                $businessprofile = $business[0]->b_image;
            }
        }
        
        $messages = DB::select("select *  from message where parent_id = ? order by send_date asc", [$conv_id, $conv_id]);
        $customername = $customerprofile = "";
        if (count($messages) > 0)
        {
            $users = DB::select("select * from users where id = ?",[$messages[0]->u_id]);
            if (count($users) > 0)
            {
                $customername = $users[0]->name;
                $customerprofile = $users[0]->userprofile;
            }
        }

        DB::update('update message set message.read = 1 WHERE (id = ? or parent_id = ?) and direct = 0',[$conv_id, $conv_id]);
        return view('/businesspage/messagedetail',['title'=>'Messages', 'messages'=>$messages, 'customername'=>$customername, 'customeravatar'=>$customerprofile, 'businessname'=>$businessname, 'businessavatar'=>$businessprofile]);
    }
    public function sendmessage(Request $request){
        $u_id = $request['u_id'];
        $b_id = $request['b_id'];
        $parent_id = $request['parent_id'];
        $content = $request['message_content'];
        $content = preg_replace("/\r\n|\r/", "<br />", $content);
        $content = trim($content);
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

        $business = DB::select("select * from business where b_id = ?", [$b_id]);
        $customer = DB::select("select * from users where id = ?", [$u_id]);
        
        $info = new \stdClass();
        $info->business = $business[0]->b_title;
        $info->content = $content_plain;
        $info->sent_date = date('Y-m-d H:i:s');

        DB::table('message')->insert(['u_id'=>$u_id, 'b_id'=>$b_id, 'parent_id'=>$parent_id, 'content'=>$content, 'content_plain'=>$content_plain, 'image'=>$filepath, 'direct'=>'1', 'read'=>'0', 'send_date'=>$info->sent_date]);
        DB::update("update message set content = ?, content_plain = ?, direct = 1, `read` = 0, send_date = ? where id = ?",[$content, $content_plain, $info->sent_date, $parent_id]);

        Mail::to($customer[0]->email)->send(
            new mailme("CUSTOMER_RECEIVE_NEWMESSAGE", $info));

        return redirect('/business/message/'.$parent_id);
    }
}
