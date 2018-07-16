<?php

namespace App\Http\Controllers\Api;

use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class Business extends Controller
{
	const DESTINATION_PATH = 'uploads/business';

    public function __construct()
    {
	}
	public function search(Request $request)
	{
		$retval = new \stdClass();
		
		$token = $request['token'];
		$zipcode = $request['zipcode'];
		$searchkey = $request['searchkey'];
		$catid = $request['cat_id'];

		$users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
		}
		
		if($searchkey ==''){
            $countSql = DB::table('business');
            $businessSql = DB::table('business');
        }else{
            $countSql = DB::table('business')->where('b_keyword', 'like', '%'.$searchkey.'%')
            ->orWhere('b_title','like', '%'.$searchkey.'%')
            ->orWhere('b_description','like', '%'.$searchkey.'%');
            $businessSql = DB::table('business')->where('b_keyword', 'like', '%'.$searchkey.'%')
            ->orWhere('b_title','like', '%'.$searchkey.'%')
            ->orWhere('b_description','like', '%'.$searchkey.'%');
        }

        if($zipcode != ''){
            $countSql = $countSql->where('postcode','like','%'.$zipcode.'%');
            $businessSql = $businessSql->where('postcode','like','%'.$zipcode.'%');
        }

        if ($catid != ''){
            $countSql = $countSql->where('b_catid',$catid);
            $businessSql = $businessSql->where('b_catid',$catid);
        }

        $countSql = $countSql->where('status', '1');
        $businessSql = $businessSql->where('status', '1');

        $count = $countSql->count();
		$business = $businessSql->get();
		
		$retval->result = "success";
		$retval->data = new \stdClass();
		$retval->err_msg = "";
		$retval->data->businesses_count = $count;
		$retval->data->businesses = array();
		foreach($business as $item)
		{
			$tmp = new \stdClass();
			$tmp->b_id = $item->b_id;
			$tmp->b_title = $item->b_title;
			$tmp->b_address = $item->address.' '.$item->city;
			$tmp->b_image = $item->b_image;
			$tmp->latitude = $item->latitude;
			$tmp->longitude = $item->longitude;
			$ratings = DB::select("select avg(rating) as ratingavg from review where b_id = ?", [$tmp->b_id]);
			if (count($ratings) > 0)
			{
				if ($ratings[0]->ratingavg != null)
					$tmp->rate = floatval(number_format((float)($ratings[0]->ratingavg), 1, '.', ''));
				else
					$tmp->rate = 0;
			}
			else
				$tmp->rate = 0;
			array_push($retval->data->businesses, $tmp);
		}

		return response()->json($retval);
	}
	
	public function detail(Request $request)
	{
		$retval = new \stdClass();
		
		$token = $request['token'];
		$b_id = $request['b_id'];

		$users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
		}

		$businesses = DB::select("select * from business where b_id = ?", [$b_id]);

		if (count($businesses) == 0)
		{
			$retval->result = "fail";
			$retval->data = array();
			$retval->err_msg = "Invalid business id";

			return response()->json($retval);
		}
		else
		{
			$business = $businesses[0];

			$retval->result = "success";
			$retval->err_msg = "";
			$retval->data = new \stdClass();
			$retval->data->b_id = $business->b_id;
			$retval->data->b_title = $business->b_title;
			$retval->data->b_headerimage = $business->b_image;
			$retval->data->b_address = $business->address.' '.$business->city;
			$retval->data->b_description = $business->b_description;
			$retval->data->latitude = $business->latitude;
			$retval->data->longitude = $business->longitude;
			$retval->data->b_website = $business->b_website;
			$retval->data->b_phone = $business->b_phone;
			$retval->data->b_email = $business->b_email;

			$countReview = 0;
			$avgReview = 0.0;
			$sum = 0;
			$ratings = DB::table('review')->where('b_id', $b_id)->get();
			foreach($ratings as $rating){
				$countReview ++;
				$sum = $sum + $rating->rating;
			}
			if($countReview != 0){
				$avgReview = round(floatval($sum / $countReview),1);
			}
	
			DB::update('update business set viewcnt = viewcnt + 1 WHERE b_id = ?',[$b_id]);
			$updatecnt = DB::update('update businessviewcnt set viewcnt = viewcnt + 1 where b_id = ? and month_col = MONTH(CURRENT_DATE) and year_col = YEAR(CURRENT_DATE)',[$b_id]);
			if ($updatecnt == 0)
				DB::insert(" insert into `businessviewcnt` (`b_id`, `year_col`, `month_col`, `viewcnt`) values (?, YEAR(CURRENT_DATE), MONTH(CURRENT_DATE), 1)", [$b_id]);

			$retval->data->b_review = $avgReview;
			$retval->data->b_reviewcnt = $countReview;
			
			$openhours = explode(',', $business->openinghours);
			$openingResult = [];
			$retval->data->opening_hours = array();
			$index = 0;

			$tmp = new \stdClass();
			
			foreach ($openhours as $openhour){
				$catch_open = explode('=', $openhour);
				
				$index++;

				if ($index == 1)
					$tmp->open = $catch_open[1];
				else
				{
					$tmp->close = $catch_open[1];
					$index = 0;
					array_push($retval->data->opening_hours, $tmp);
					$tmp = new \stdClass();
				}
			}

			return response()->json($retval);
		}
	}
	
	public function businesslisting(Request $request)
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

		$businesses = DB::select("select * from business where userid = ?", [$user->id]);

		if (count($businesses) == 0)
		{
			$retval->result = "fail";
			$retval->data = array();
			$retval->err_msg = "Invalid business id";

			return response()->json($retval);
		}
		else
		{
			$business = $businesses[0];

			$retval->result = "success";
			$retval->err_msg = "";
			$retval->data = new \stdClass();
			$retval->data->b_id = $business->b_id;
			$retval->data->b_title = $business->b_title;
			$retval->data->b_catid = $business->b_catid;
			$retval->data->b_category = $business->b_category;
			$retval->data->keyword = $business->b_keyword;
			$retval->data->city = $business->city;
			$retval->data->address = $business->address;
			$retval->data->state = $business->state;
			$retval->data->postcode = $business->postcode;
			$retval->data->b_image = $business->b_image;
			$retval->data->b_headerimage = $business->b_headerimage;
			$retval->data->b_description = $business->b_description;
			$retval->data->latitude = $business->latitude;
			$retval->data->longitude = $business->longitude;
			$retval->data->b_website = $business->b_website;
			$retval->data->b_phone = $business->b_phone;
			$retval->data->b_email = $business->b_email;

			$openhours = explode(',', $business->openinghours);
			$openingResult = [];
			$retval->data->opening_hours = array();
			$index = 0;

			$tmp = new \stdClass();
			
			foreach ($openhours as $openhour){
				$catch_open = explode('=', $openhour);
				
				$index++;

				if ($index == 1)
					$tmp->open = $catch_open[1];
				else
				{
					$tmp->close = $catch_open[1];
					$index = 0;
					array_push($retval->data->opening_hours, $tmp);
					$tmp = new \stdClass();
				}
			}

			return response()->json($retval);
		}
	}
	
	public function editbusinesslisting(Request $request)
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

		$title = $request['title'];
		$catid = $request['catid'];
		$keyword = $request['keyword'];
		$city = $request['city'];
		$address = $request['address'];
		$state = $request['state'];
		$postcode = $request['postcode'];
		$image = self::fileUpload($request, 'image');
		$headerimage = self::fileUpload($request, 'headerimage');
		$description = $request['description'];
		$website = $request['website'];
		$phone = $request['phone'];
		$email = $request['email'];
		$openinghours = '';
		if($request->has($request['o_moday'])){
			$input = array('o_mon'=>$request['open_1'],'c_mon'=>$request['close_1'],'o_tue'=>$request['open_2'],'c_tue'=>$request['close_2'],
				'o_wed'=>$request['open_3'],'c_wed'=>$request['close_3'],'o_thu'=>$request['open_4'],'c_thu'=>$request['close_4'],
				'o_fri'=>$request['open_5'],'c_fri'=>$request['close_5'],'o_sat'=>$request['open_6'],'c_sat'=>$request['close_6'],
				'o_sun'=>$request['open_7'],'c_sun'=>$request['close_7']);
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

		$str_res = $address.' '.$city.' '.$state;
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
		$categorynames = DB::select("select categoryname from category where id = ?", [$catid]);
		$categoryname = "";
		if (count($categorynames) > 0)
			$categoryname = $categorynames[0]->categoryname;

		DB::update('update business set b_title = ?, b_catid = ?, b_category = ?, b_keyword = ?, state = ?, city = ?, address = ?, postcode = ?,
		b_description = ?, b_phone = ?, b_website = ?, b_email = ?, openinghours = ?, latitude = ?, longitude = ?, bupdate = ? WHERE userid = ?',
		[$title,$catid, $categoryname, $keyword, $state, $city, $address, $postcode,
		$description, $phone, $website, $email, $openinghours,
		$lat, $long, 'false', $user->id]);

		if ($image != "")
			DB::update('update business set b_image = ? WHERE userid = ?', [$image, $user->id]);
		if ($headerimage != "")
			DB::update('update business set b_headerimage = ? WHERE userid = ?', [$headerimage, $user->id]);

		$retval->result = "success";
		$retval->data = new \stdClass();
        $retval->err_msg = "";
        return response()->json($retval);
	}

	public function getpackage(Request $request)
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

		$businesses = DB::select("select * from business where userid = ?", [$user->id]);
		
		if (count($businesses) == 0)
		{
			$retval->result = "fail";
			$retval->data = array();
			$retval->err_msg = "Invalid business id";

			return response()->json($retval);
		}
		else
		{
			$business = $businesses[0];

			$retval->result = "success";
			$retval->data = new \stdClass();
			$retval->err_msg = "";

			$retval->data->package = $user->package;
			$retval->data->free = DB::table('packageprice')->where('packagename','free')->value('price');
			$retval->data->basic = DB::table('packageprice')->where('packagename','basic')->value('price');
			$retval->data->regular = DB::table('packageprice')->where('packagename','regular')->value('price');
			$retval->data->premium = DB::table('packageprice')->where('packagename','premium')->value('price');
			$retval->data->couponcode = $business->couponcode;
			$salesstaff = DB::select("select * from salesstaff where couponcode = ?", [$retval->data->couponcode]);
			
			if (count($salesstaff) > 0)
			{
				$type = $salesstaff[0]->discounttype;
				$price = $salesstaff[0]->discountprice;
				if ($type == 0)
				{
					$retval->data->free = $retval->data->free / 100 * (100 - $price);
					$retval->data->basic = $retval->data->basic / 100 * (100 - $price);
					$retval->data->regular = $retval->data->regular / 100 * (100 - $price);
					$retval->data->premium = $retval->data->premium / 100 * (100 - $price);
				}
				else
				{
					$retval->data->free = $retval->data->free - $price;
					$retval->data->basic = $retval->data->basic - $price;
					$retval->data->regular = $retval->data->regular - $price;
					$retval->data->premium = $retval->data->premium - $price;
	
					if ($retval->data->free < 0) $retval->data->free = 0;
					if ($retval->data->basic < 0) $retval->data->basic = 0;
					if ($retval->data->regular < 0) $retval->data->regular = 0;
					if ($retval->data->premium < 0) $retval->data->premium = 0;
				}
			}
		}

		return response()->json($retval);
	}

	public function setpackage(Request $request)
	{
		$retval = new \stdClass();
		
		$token = $request['token'];
		$package = $request['package'];
		
		$users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
		}
		$user = $users[0];

		DB::update("update users set package = ?  where app_token = ?", [$package, $token]);

		$retval->result = "success";
		$retval->data = new \stdClass();
        $retval->err_msg = "";
        return response()->json($retval);
	}

	public function setcouponcode(Request $request)
	{
		$retval = new \stdClass();
		
		$token = $request['token'];
		$couponcode = $request['couponcode'];
		
		$users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
		}
		$user = $users[0];

		if ($couponcode == "")
        {
			DB::update("update business set couponcode = '' where userid = ?",[$user->id]);
		}
		else
		{
			$retVal = DB::select("select * from salesstaff where couponcode = ?", [$couponcode]);
			if (count($retVal) > 0)
			{
				DB::update("update business set couponcode = ?  where userid = ?", [$couponcode, $user->id]);
			}
			else
			{
				$retval->result = "error";
				$retval->data = new \stdClass();
				$retval->err_msg = "Invalid Coupon Code";

				return response()->json($retval);
			}
		}

		$retval->result = "success";
		$retval->data = new \stdClass();
        $retval->err_msg = "";
        return response()->json($retval);
	}

	public function getdashboardinfo(Request $request)
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

		$businesses = DB::select("select * from business where userid = ?", [$user->id]);
		
		if (count($businesses) == 0)
		{
			$retval->result = "fail";
			$retval->data = array();
			$retval->err_msg = "Invalid business id";

			return response()->json($retval);
		}
		else
		{
			$business = $businesses[0];

			$retval->result = "success";
			$retval->data = new \stdClass();
			$retval->err_msg = "";

			$temp = DB::select("select count(id) as activeproject from project where b_id = ? and status = 1", [$business->b_id]);
			if (count($temp) == 0 || $temp[0]->activeproject == null)
				$retval->data->activeproject = 0;
			else
				$retval->data->activeproject = $temp[0]->activeproject;
	
			$temp = DB::select("select count(price) as completeproject from project where b_id = ? and status = 3 and month(create_date) = month(current_date()) and year(create_date) = year(current_date())", [$business->b_id]);
			if (count($temp) == 0 || $temp[0]->completeproject == null)
				$retval->data->completedproject = 0;
			else
				$retval->data->completedproject = $temp[0]->completeproject;
	
			$temp = DB::select("select sum(price) as monthlysale from project where b_id = ? and status = 3 and month(create_date) = month(current_date()) and year(create_date) = year(current_date())", [$business->b_id]);
			if (count($temp) == 0 || $temp[0]->monthlysale == null)
				$retval->data->thismonth = 0;
			else
				$retval->data->thismonth = $temp[0]->monthlysale;
	
			$temp = DB::select("select sum(price) as totalsale from project where b_id = ? and status = 3", [$business->b_id]);
			if (count($temp) == 0 || $temp[0]->totalsale == null)
				$retval->data->totalsale = 0;
			else
				$retval->data->totalsale = $temp[0]->totalsale;
	
			$retval->data->visitnum = array();
			for($i = 0; $i < 6; $i++)
			{
				$temp = DB::select("select * FROM businessviewcnt WHERE year_col = YEAR(CURRENT_DATE - INTERVAL ".$i." MONTH) AND month_col = MONTH(CURRENT_DATE - INTERVAL ".$i." MONTH) AND b_id = ?", [$business->b_id]);
				if (count($temp) == 0)
					array_push($retval->data->visitnum, 0);
				else
					array_push($retval->data->visitnum, $temp[0]->viewcnt);
			}
	
			$temp = DB::select("select A.id, A.title, A.image, B.email, (SELECT DATE_ADD(create_date, INTERVAL delay_day DAY)) as enddate from project A
								left join users B on A.u_id = B.id
								where A.b_id = ? and A.status = 1
								order by enddate asc limit 0, 5", [$business->b_id]);

			$retval->data->nextproject = array();
			foreach ($temp as $item)
			{
				$tmp = new \stdClass();

				$tmp->p_id = $item->id;
				$tmp->image = $item->image;
				$tmp->title = $item->title;
				$tmp->customer = $item->email;
				$tmp->enddate = $item->enddate;
				
				array_push($retval->data->nextproject, $tmp);
			}
		}

		return response()->json($retval);
	}

	public function getreview(Request $request)
	{
		$retval = new \stdClass();
		
		$token = $request['token'];
		$b_id = $request['b_id'];
		$pagesize = isset($request['pagesize']) && $request['pagesize'] != "" ? $request['pagesize'] : 0;
        $pagenum = isset($request['pagenum']) && $request['pagesize'] != "" ? $request['pagenum'] : 0;
		
		$users = DB::select("select * from users where app_token = ?", [$token]);
		if (count($users) == 0)
		{
			$retval->result = "invalid_token";
			$retval->data = array();
			$retval->err_msg = "Invalid token";

			return response()->json($retval);
		}
		$user = $users[0];

		$businesses = DB::select("select * from business where b_id = ?", [$b_id]);
		
		if (count($businesses) == 0)
		{
			$retval->result = "fail";
			$retval->data = array();
			$retval->err_msg = "Invalid business id";

			return response()->json($retval);
		}
		else
		{
			$business = $businesses[0];

			$retval->result = "success";
			$retval->data = new \stdClass();
			$retval->err_msg = "";

			$retval->data->b_title = $business->b_title;
			$retval->data->b_address = $business->address.' '.$business->city;
			$ratings = DB::select("select avg(rating) as ratingavg, count(rating) as ratingcnt from review where b_id = ?", [$b_id]);
			if (count($ratings) > 0)
			{
				if ($ratings[0]->ratingavg != null)
				{
					$retval->data->b_rating = (float)(number_format((float)($ratings[0]->ratingavg), 1, '.', '').'0');
					$retval->data->reviewcnt = $ratings[0]->ratingcnt;
				}
				else
				{
					$retval->data->b_rating = 0;
					$retval->data->reviewcnt = 0;
				}
			}
			else
			{
				$retval->data->b_rating = 0;
				$retval->data->reviewcnt = 0;
			}
			
			if ($pagesize > 0)
				$reviews = DB::select("select * from review where b_id = ? order by create_date desc limit ?, ?", [$b_id, $pagenum * $pagesize, $pagesize]);
			else
				$reviews = DB::select("select * from review where b_id = ? order by create_date desc", [$b_id]);

			$retval->data->listcnt = count($reviews);
			$retval->data->reviewlist = array();
			foreach($reviews as $item)
			{
				$tmp = new \stdClass();

				$tmp->review_id = $item->id;
				$tmp->p_title = $item->p_title;
				$tmp->c_avatar = $item->u_avatar;
				$tmp->date = $item->create_date;
				$tmp->rate = (float)(number_format((($item->communication + $item->quality + $item->speed) / 3), 1, '.', '').'0');
				$tmp->description = $item->review;
				
				array_push($retval->data->reviewlist, $tmp);
			}
		}

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