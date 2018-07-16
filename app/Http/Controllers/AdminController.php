<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Http\Requests;
use Datatables;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return redirect('admin/dashboard');
    }
    public function dashboard(){
        $info = new \stdClass();
        $temp = DB::select("select sum(price) as totalsales from subscriptionsale");
        if (count($temp) == 0 && $temp[0]->totalsales == null)
            $info->totalsales = 0;
        else
            $info->totalsales = $temp[0]->totalsales;
            
        $temp = DB::select("select count(b_id) as totalbusiness from business");
        if (count($temp) == 0 && $temp[0]->totalbusiness == null)
            $info->totalbusiness = 0;
        else
            $info->totalbusiness = $temp[0]->totalbusiness;

        $temp = DB::select("select count(id) as totalcustomer from users where userrole = 'customer'");
        if (count($temp) == 0 && $temp[0]->totalcustomer == null)
            $info->totalcustomer = 0;
        else
            $info->totalcustomer = $temp[0]->totalcustomer;

        $temp = DB::select("select count(A.b_id) as freebusiness from business A left join users B on A.userid = B.id where B.package = 'free'");
        if (count($temp) == 0 && $temp[0]->freebusiness == null)
            $info->freebusiness = 0;
        else
            $info->freebusiness = $temp[0]->freebusiness;

        $temp = DB::select("select count(A.b_id) as basicbusiness from business A left join users B on A.userid = B.id where B.package = 'basic'");
        if (count($temp) == 0 && $temp[0]->basicbusiness == null)
            $info->basicbusiness = 0;
        else
            $info->basicbusiness = $temp[0]->basicbusiness;

        $temp = DB::select("select count(A.b_id) as regularbusiness from business A left join users B on A.userid = B.id where B.package = 'regular'");
        if (count($temp) == 0 && $temp[0]->regularbusiness == null)
            $info->regularbusiness = 0;
        else
            $info->regularbusiness = $temp[0]->regularbusiness;

        $temp = DB::select("select count(A.b_id) as premiumbusiness from business A left join users B on A.userid = B.id where B.package = 'premium'");
        if (count($temp) == 0 && $temp[0]->premiumbusiness == null)
            $info->premiumbusiness = 0;
        else
            $info->premiumbusiness = $temp[0]->premiumbusiness;
        
        $temp = DB::select("select A.b_id, A.b_title, A.b_image, SUM(B.price) as b_sales from business A
                            left join project B on A.b_id = B.b_id
                            where B.`status` = 3
                            GROUP BY A.b_id, A.b_title, A.b_image
                            ORDER BY b_sales desc
                            limit 0, 5");
        $info->topearnedbusiness = $temp;

        $temp = DB::select("select b_id, b_title, b_image, viewcnt from business order by viewcnt desc limit 0, 5");
        $info->topviewedbusiness = $temp;

        $temp = DB::select("select count(id) as customercnt_30 from users where userrole = 'customer' and created_at < (SELECT DATE_ADD(NOW(), INTERVAL -30 DAY))");
        if (count($temp) == 0 && $temp[0]->customercnt_30 == null)
            $info->customercnt_30 = 0;
        else
            $info->customercnt_30 = $temp[0]->customercnt_30;

        $temp = DB::select("select count(id) as customercnt_14 from users where userrole = 'customer' and created_at < (SELECT DATE_ADD(NOW(), INTERVAL -14 DAY))");
        if (count($temp) == 0 && $temp[0]->customercnt_14 == null)
            $info->customercnt_14 = 0;
        else
            $info->customercnt_14 = $temp[0]->customercnt_14;

        $temp = DB::select("select count(id) as customercnt_7 from users where userrole = 'customer' and created_at < (SELECT DATE_ADD(NOW(), INTERVAL -7 DAY))");
        if (count($temp) == 0 && $temp[0]->customercnt_7 == null)
            $info->customercnt_7 = 0;
        else
            $info->customercnt_7 = $temp[0]->customercnt_7;

        $temp = DB::select("select count(id) as businesscnt_30 from users where userrole = 'business' and created_at < (SELECT DATE_ADD(NOW(), INTERVAL -30 DAY))");
        if (count($temp) == 0 && $temp[0]->businesscnt_30 == null)
            $info->businesscnt_30 = 0;
        else
            $info->businesscnt_30 = $temp[0]->businesscnt_30;

        $temp = DB::select("select count(id) as businesscnt_14 from users where userrole = 'business' and created_at < (SELECT DATE_ADD(NOW(), INTERVAL -14 DAY))");
        if (count($temp) == 0 && $temp[0]->businesscnt_14 == null)
            $info->businesscnt_14 = 0;
        else
            $info->businesscnt_14 = $temp[0]->businesscnt_14;

        $temp = DB::select("select count(id) as businesscnt_7 from users where userrole = 'business' and created_at < (SELECT DATE_ADD(NOW(), INTERVAL -7 DAY))");
        if (count($temp) == 0 && $temp[0]->businesscnt_7 == null)
            $info->businesscnt_7 = 0;
        else
            $info->businesscnt_7 = $temp[0]->businesscnt_7;

        return view('adminpage/dashboard', array('title' => 'Dashboard', 'info' => $info));
    }
    //------admin------
    public function adminusers(){
        return view('adminpage/adminusers', array('title' => 'Admin Users'));
    }
    public function adminusers_table_getall()
    {
        $users = DB::table('users')->select('id', 'email', 'created_at')->where('userrole','admin');
        return Datatables::of($users)
            ->make(true);
    }
    public function adminusersadd(){
        return view('adminpage/adminusersadd', array('title' => 'Admin Users'));
    }
    public function adminusersadd_save(Request $request){
        DB::table('users')->insert(['name'=>$request['email'],'email'=>$request['email'], 'password'=>Hash::make($request['newpwd']), 'userrole'=>'admin', 
        'created_at'=>date('Y-m-d H:i:s'), 'updated_at'=>date('Y-m-d H:i:s')]);

        return redirect('admin/adminusers');
    }

    //--------saless staff---------
    public function salesstaff(){
        return view('adminpage/salesstaff', array('title' => 'Sales Staff'));
    }
    public function salesstaff_table_getall()
    {
        $salesstaff = DB::select("select * from salesstaff");
        foreach ($salesstaff as $member)
        {
            $monthly = DB::select("select SUM(C.price) as monthlysale from business A
                                    left join users B on A.userid = B.id
                                    left join packageprice C on B.package = C.packagename COLLATE utf8_unicode_ci
                                    where A.couponcode = ?", [$member->couponcode]);
            $member->monthlysale = $monthly[0]->monthlysale;
        }

        return Datatables::of($salesstaff)
            ->make(true);
    }
    public function salesstaff_generatecouponcode() {
        $bExist = 1;
        $length = 5;
        $rescode = "";
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        
        while ($bExist)
        {
            $rescode = "";
            for ($i = 0; $i < $length; $i++) {
                $rescode .= $characters[rand(0, $charactersLength - 1)];
            }
            $check = DB::select("select count(id) as couponcount from salesstaff where couponcode = '?'", [$rescode]);
            $bExist = $check[0]->couponcount;
        }

        return $rescode;
    }
    public function salesstaff_edit(Request $request){
        $id = $request['edit_id'];
        if ($id > 0)
        {
            $userdata = DB::select('select * from salesstaff WHERE id = ?',[$id]);
            $name = $userdata[0] -> membername;
            $phone = $userdata[0] -> phone;
            $email = $userdata[0] -> email;
            $discounttype = $userdata[0] -> discounttype;
            $discountprice = $userdata[0] -> discountprice;
            $couponcode = $userdata[0] -> couponcode;
        }
        else
        {
            $name = "";
            $phone = "";
            $email = "";
            $discounttype = 0;
            $discountprice = 0;
            $couponcode = AdminController::salesstaff_generatecouponcode();
        }

        return view('adminpage/salesstaffedit', array('title' => 'Sales Staff', 'name' => $name, 'phone' => $phone, 'email' => $email, 'discounttype' => $discounttype, 'discountprice' => $discountprice, 'couponcode' => $couponcode, 'edit_id' => $id));
    }
    public function salesstaff_table_getallbusiness(Request $request)
    {
        $salesid = $request['salesid'];
        $salesstaff = DB::select("select * from salesstaff where id = ?", [$salesid]);

        $business = DB::select("select A.b_id, A.b_title, A.b_image, A.b_category, B.package, C.price from business A 
                                left join users B on A.userid = B.id 
                                left join packageprice C on B.package = C.packagename COLLATE utf8_unicode_ci
                                where A.couponcode = ?", [$salesstaff[0]->couponcode]);
        return Datatables::of($business)
            ->make(true);
    }
    public function salesstaff_checkregister(Request $request) {
        $edit_id = $request['editid'];
        $name = $request['name'];
        $email = $request['email'];
        $couponcode = $request['couponcode'];
        
        $user = DB::select("select * from salesstaff where membername = ? and id <> ?", [$name, $edit_id]);
        $result = "";
        
        if (count($user) > 0)
        {
            $result = "{\"res\":\"error\", \"status\":\"Name is already exist\"}";
        }
        else
        {
            $user = DB::select("select * from salesstaff where email = ? and id <> ?", [$email, $edit_id]);

            if (count($user) > 0)
            {
                $result = "{\"res\":\"error\", \"status\":\"Email is already exist\"}";
            }
            else
            {
                $user = DB::select("select * from salesstaff where couponcode = ? and id <> ?", [$couponcode, $edit_id]);
                
                if (count($user) > 0)
                {
                    $result = "{\"res\":\"error\", \"status\":\"Coupon Code is already exist\"}";
                }
                else
                    $result = "{\"res\":\"success\"}";
            }
        }
        print_r($result);
    }
    public function salesstaff_editsave(Request $request){
        if ($request['edit_id'] == 0)
            DB::table('salesstaff')->insert(['membername'=>$request['name'],'email'=>$request['email'],'phone'=>$request['phone'],'discounttype'=>$request['discounttype'],'discountprice'=>$request['discountprice'],'couponcode'=>$request['couponcode'],'created_at'=>date('Y-m-d H:i:s')]);
        else
            DB::update("update salesstaff set membername = ?, email = ?, phone = ?, discounttype = ?, discountprice = ?, couponcode = ? where id = ?", [$request['name'],$request['email'],$request['phone'],$request['discounttype'],$request['discountprice'],$request['couponcode'],$request['edit_id']]);

        return redirect('admin/salesstaff');
    }
    public function salesstaff_del(Request $request){
        $couponcode = $request['couponcode'];

        $retVal = DB::select("select * from business where couponcode = ?", [$couponcode]);
        $result = "";
        if (count($retVal) > 0)
        {
            $result = "{\"res\":\"false\",\"errmsg\":\"This Sales Staff's Coupon Code is using by some business\"}";
        }
        else
        {
            $retVal = DB::delete("delete from salesstaff where couponcode = ?", [$couponcode]);
    
            if ($retVal > 0)
                $result = "{\"res\":\"true\"}";
            else
                $result = "{\"res\":\"false\",\"errmsg\":\"Delete failed\"}";
        }

        print_r($result);
    }

    //--------categories--------
    public function categories(){
        return view('adminpage/categories', array('title' => 'Categories'));
    }
    public function categories_table_getall()
    {
        $category = DB::select("select * from category");
        return Datatables::of($category)
            ->make(true);
    }
    public function categories_edit(Request $request){
        $id = $request['edit_id'];
        if ($id > 0)
        {
            $userdata = DB::select('select * from category WHERE id = ?',[$id]);
            $name = $userdata[0] -> categoryname;
            $photo = $userdata[0] -> category_photo;
        }
        else
        {
            $name = "";
            $photo = "";
        }

        return view('adminpage/categoriesedit', array('title' => 'Categories', 'name' => $name, 'photo' => $photo, 'edit_id' => $id));
    }
    public function categories_checkregister(Request $request) {
        $edit_id = $request['editid'];
        $name = $request['name'];
        
        $user = DB::select("select * from category where categoryname = ? and id <> ?", [$name, $edit_id]);
        $result = "";
        
        if (count($user) > 0)
        {
            $result = "{\"res\":\"error\", \"status\":\"Name is already exist\"}";
        }
        else
        {
            $result = "{\"res\":\"success\"}";
        }
        print_r($result);
    }
    public function categories_save(Request $request){
        $edit_id = $request['edit_id'];
        
        if ($edit_id == 0)
            DB::table('category')->insert(['categoryname'=>$request['name'], 'category_photo'=>$request['iconpicker']]);
        else
        {
            DB::update("update category set categoryname = ?, category_photo = ? where id = ?", [$request['name'], $request['iconpicker'], $edit_id]);
            DB::update("update business set b_category = ? where b_catid = ?", [$request['name'], $edit_id]);
        }

        /* upload photo end */

        return redirect('admin/categories');
    }
    public function categories_del(Request $request){
        $id = $request['edit_id'];

        $retVal = DB::select("select * from business where b_catid = ?", [$id]);
        $result = "";
        if (count($retVal) > 0)
        {
            $result = "{\"res\":\"false\",\"errmsg\":\"This Category is using by some business\"}";
        }
        else
        {
            $retVal = DB::delete("delete from category where id = ?", [$id]);
    
            if ($retVal > 0)
                $result = "{\"res\":\"true\"}";
            else
                $result = "{\"res\":\"false\",\"errmsg\":\"Delete failed\"}";
        }

        print_r($result);
    }
    //--------package price---------
    public function packageprice() {
        $packageprice = new \stdClass();
        $packageprice->free = DB::table('packageprice')->where('packagename','free')->value('price');
        $packageprice->basic = DB::table('packageprice')->where('packagename','basic')->value('price');
        $packageprice->regular = DB::table('packageprice')->where('packagename','regular')->value('price');
        $packageprice->premium = DB::table('packageprice')->where('packagename','premium')->value('price');

        return view('adminpage/packageprice', array('title' => 'Package Price', 'packageprice' => $packageprice));
    }
    public function packageprice_save(Request $request) {
        $free = $request['free'];
        $basic = $request['basic'];
        $regular = $request['regular'];
        $premium = $request['premium'];

        DB::update("update packageprice set price = ? where packagename = 'free'",[$free]);
        DB::update("update packageprice set price = ? where packagename = 'basic'",[$basic]);
        DB::update("update packageprice set price = ? where packagename = 'regular'",[$regular]);
        DB::update("update packageprice set price = ? where packagename = 'premium'",[$premium]);

        return redirect('admin/packageprice');
    }
    //--------setting---------
    public function setting(){
        $setting = new \stdClass();
        $setting->homepageimage = DB::table('setting')->where('setting_name','homepageimage')->value('setting_value');
        $setting->contactpageimage = DB::table('setting')->where('setting_name','contactpageimage')->value('setting_value');
        $setting->aboutus = DB::table('setting')->where('setting_name','aboutus')->value('setting_value');
        $setting->contactus = DB::table('setting')->where('setting_name','contactus')->value('setting_value');
        return view('adminpage/setting', array('title' => 'Setting', 'setting'=>$setting));
    }
    public function setting_save_homepageimage(Request $request){
        $file = $request->file('profile_image');
        if(isset($file)){
            $extention = $file->getClientOriginalExtension();
            $filename = 'homepageimage_'.date('His').'.'.$extention;
            $destinationPath = 'uploads/setting';
            $file->move($destinationPath, $filename);
            $filepath = $destinationPath.'/'.$filename;
        }
        else{
            $filepath = '';
        }

        if ($filepath != '')
            DB::update("update setting set setting_value = ? where setting_name = 'homepageimage'",[$filepath]);
        DB::update("update setting set setting_value = ? where setting_name = 'aboutus'",[$request['aboutus']]);
        return redirect('admin/setting');
    }
    public function setting_save_contactpageimage(Request $request){
        $file = $request->file('profile_image');
        if(isset($file)){
            $extention = $file->getClientOriginalExtension();
            $filename = 'contactpageimage_'.date('His').'.'.$extention;
            $destinationPath = 'uploads/setting';
            $file->move($destinationPath, $filename);
            $filepath = $destinationPath.'/'.$filename;
        }
        else{
            $filepath = '';
        }

        if ($filepath != '')
            DB::update("update setting set setting_value = ? where setting_name = 'contactpageimage'",[$filepath]);
        DB::update("update setting set setting_value = ? where setting_name = 'contactus'",[$request['contactus']]);
        return redirect('admin/setting');
    }
    //--------customer---------
    public function customers(){
        return view('adminpage/customers', array('title' => 'Customers'));
    }
    public function customers_table_getall()
    {
        $users = DB::table('users')->select('id', 'name', 'email', 'userprofile', 'created_at', 'status')->where('userrole','customer');

        return Datatables::of($users)
            ->make(true);
    }
    public function customers_setactive(Request $request)
    {
        $id = $request['id'];
        $isActive = $request['bActive'];
        $retVal = DB::update('update users set status = ? WHERE id = ?',[$isActive, $id]);

        $result = "";
        if ($retVal > 0)
            $result = "{\"res\":\"true\"}";
        else
        $result = "{\"res\":\"false\"}";
        
        print_r($result);
    }
    public function customers_profile(Request $request){
        $id = $request['edit_id'];
        $userdata = DB::select('select * from users WHERE id = ?',[$id]);
        $name = $userdata[0] -> name;
        $phone = $userdata[0] -> userphone;
        $email = $userdata[0] -> email;
        $notes = $userdata[0] -> notes;
        $profileImage = $userdata[0] -> userprofile;

        return view('adminpage/customersedit', array('title' => 'Customers', 'name' => $name, 'phone' => $phone, 'email' => $email, 'notes' => $notes, 'profileImage' => $profileImage, 'edit_id' => $id));
    }
    public function customers_saveprofile(Request $request){
        $id = $request['edit_id'];
        $user = DB::table('users')->where('id',$id)->first();

        $file = $request->file('profile_image');
        if(isset($file)){
            $extention = $file->getClientOriginalExtension();
            $filename = $user->email.'_'.date('His').'.'.$extention;
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
        
        if ($filepath != '')
            DB::update('update users set name = ?, userphone = ?, email = ?, notes = ?, userprofile = ? WHERE id = ?',[$name, $phone, $email, $notes, $filepath, $id]);
        else
            DB::update('update users set name = ?, userphone = ?, email = ?, notes = ? WHERE id = ?',[$name, $phone, $email, $notes, $id]);
        return redirect('admin/customers');
    }

    //--------business---------
    public function business(){
        return view('adminpage/business', array('title' => 'Business'));
    }
    public function business_table_getall()
    {
        $business = DB::select("select A.b_id, A.userid, A.b_title, A.b_image, A.b_category, A.postcode, B.email as b_email, A.status from business A
                                left join users B on A.userid = B.id");

        foreach ($business as $item)
        {
            $prices = DB::select("select SUM(price) as totalprice from project where b_id = ? and status = 3", [$item->b_id]);
            if (count($prices) > 0)
            {
                if ($prices[0]->totalprice != null && $prices[0]->totalprice != "")
                    $item->totalprice = $prices[0]->totalprice;
                else
                    $item->totalprice = 0;
            }
            else
                $item->totalprice = 0;
        }

        return Datatables::of($business)
            ->make(true);
    }
    public function business_setactive(Request $request)
    {
        $id = $request['id'];
        $isActive = $request['bActive'];
        $retVal = DB::update('update business set status = ? WHERE b_id = ?',[$isActive, $id]);

        $result = "";
        if ($retVal > 0)
            $result = "{\"res\":\"true\"}";
        else
        $result = "{\"res\":\"false\"}";
        
        print_r($result);
    }
    public function business_profile(Request $request){
        $b_id = $request['edit_id'];
        $u_id = DB::table('business')->where('b_id',$b_id)->first()->userid;

        $userdata = DB::select('select * from users WHERE id = ?',[$u_id]);
        $name = $userdata[0] -> name;
        $phone = $userdata[0] -> userphone;
        $email = $userdata[0] -> email;
        $notes = $userdata[0] -> notes;
        $profileImage = $userdata[0] -> userprofile;

        return view('adminpage/businessprofileedit', array('title' => 'Business', 'name' => $name, 'phone' => $phone, 'email' => $email, 'notes' => $notes, 'profileImage' => $profileImage, 'edit_id' => $u_id));
    }
    public function business_saveprofile(Request $request){
        $id = $request['edit_id'];
        $user = DB::table('users')->where('id',$id)->first();

        $file = $request->file('profile_image');
        if(isset($file)){
            $extention = $file->getClientOriginalExtension();
            $filename = $user->email.'_'.date('His').'.'.$extention;
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
        $id = $request['edit_id'];
        if ($filepath != '')
            DB::update('update users set name = ?, userphone = ?, email = ?, notes = ?, userprofile = ? WHERE id = ?',[$name, $phone, $email, $notes, $filepath, $id]);
        else
            DB::update('update users set name = ?, userphone = ?, email = ?, notes = ? WHERE id = ?',[$name, $phone, $email, $notes, $id]);
        return redirect('admin/business');
    }
    public function business_business(Request $request)
    {
        $b_id = $request['edit_id'];
        $u_id = DB::table('business')->where('b_id',$b_id)->first()->userid;
        $categories = DB::select("select * from category order by categoryname");

        $package = DB::table('users')->where('id',$u_id)->value('package');
        $res1 = DB::table('business')->where('userid',$u_id)->first();
        return view('adminpage/businessbusinessedit', array('title' => 'Business', 'edit_id' => $b_id, 'package'=>$package, 'b_res'=>$res1, 'b_check'=>'false', 'categories'=>$categories));
    }
    public function business_savebusiness(Request $request){
        $b_id = $request['edit_id'];
        $u_id = DB::table('business')->where('b_id',$b_id)->first()->userid;
        $user = DB::table('users')->where('id',$u_id)->first();

        $destinationPath = 'uploads/business';
        $res = DB::table('business')->where('userid',$u_id)->first();
        if($request->file('business-main-img') != null){
            $file_main = $request->file('business-main-img');
            $extention_main = $file_main->getClientOriginalExtension();
            $filename_main = $user->email.'_main_'.date('His').'.'.$extention_main;
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
            $filename_listing = $user->email.'_listing_'.date('His').'.'.$extention_listing;
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
            $lat, $long, 'false', $u_id]);

        return redirect('admin/business');
    }

    //--------Review---------
    public function review(){
        return view('adminpage/review', array('title' => 'Reviews'));
    }
    public function review_table_getall()
    {
        $review = DB::select("select A.id as id, B.b_title as b_title, A.create_date as create_date, A.review as review from review A left join business B on A.b_id = B.b_id");

        return Datatables::of($review)
            ->make(true);
    }
    public function review_getreview(Request $request){
        $id = $request['id'];
        $review = DB::select("select review from review where id = ?", [$id])[0]->review;

        return view('adminpage/reviewedit', array('title' => 'Reviews', 'review' => $review, 'edit_id' => $id));
    }
    public function review_savereview(Request $request){
        $id = $request['edit_id'];
        $review = $request['review'];
        $review = DB::update("update review set review = ? where id = ?", [$review, $id]);
        return redirect('admin/review');
    }
    public function review_delreview(Request $request){
        $id = $request['id'];
        $retVal = DB::delete("delete from review where id = ?", [$id]);

        $result = "";
        if ($retVal > 0)
            $result = "{\"res\":\"true\"}";
        else
        $result = "{\"res\":\"false\"}";
        
        print_r($result);
    }
    //---------------contact---------------
    public function contact(){
        return view('adminpage/contact', array('title' => 'Contact Message'));
    }
    public function contact_table_getall()
    {
        $message = DB::select("select * from contactmessage order by create_at desc");

        return Datatables::of($message)
            ->make(true);
    }
    //---------------professionalheader---------------
    public function professionalheader(){
        return view('adminpage/professionalheader', array('title' => 'Professional Header'));
    }
    public function professionalheader_table_getall()
    {
        $message = DB::select("select A.*, B.b_title from professionalheader A
                               left join business B on A.b_id = B.b_id
                               order by create_at desc");

        return Datatables::of($message)
            ->make(true);
    }

    //---------profile-----------
    public function profile(){
        $id = Auth::user()->id;
        $userdata = DB::select('select * from users WHERE id = ?',[$id]);
        $email = $userdata[0] -> email;
        $profileImage = $userdata[0] -> userprofile;

        return view('adminpage/profile', array('title' => 'My Profile', 'profileImage' => $profileImage, 'email' => $email));
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
        
        $email = $request['email'];
        $id = Auth::user()->id;
        if ($filepath != '')
            DB::update('update users set email = ?, userprofile = ? WHERE id = ?',[$email, $filepath, $id]);
        else
            DB::update('update users set email = ? WHERE id = ?',[$email, $id]);
        return redirect('admin/profile');
    }

    public function resetprofile(Request $request){
        $old_pwd = $request['oldpwd'];
        if(!Hash::check($old_pwd, Auth::user()->getAuthPassword())){
            return redirect('admin/profile')->with('oldpwd', 'false');
        }
        else{
            $this->validate($request,[
                'newpwd'=>'confirmed'
            ]);
            $newpassword =  Hash::make($request['newpwd']);
            DB::update('update users set password = ? WHERE id = ?',[$newpassword, Auth::id()]);
            return redirect('admin/profile')->with(['success'=>'Reset password successfully'])->withInput();
        }
    }
}
