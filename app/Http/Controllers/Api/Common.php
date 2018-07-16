<?php

namespace App\Http\Controllers\Api;

use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class Common extends Controller
{
	const DESTINATION_PATH = 'uploads/business';

    public function __construct()
    {
	}
	
	public function homeinfo(Request $request)
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

		$businesses = DB::select("select A.* from business A left join users B on A.userid = B.id where B.package = 'premium' and A.status = 1");
        $categories = DB::select("select D.* from (select A.id, COUNT(B.b_id) as cnt from category A
                                    left join business B on A.id = B.b_catid
                                    where B.`status` = 1
                                    GROUP BY A.id
                                    order by cnt desc
                                    limit 0, 6) C
									left join category D on C.id = D.id");
		
		$retval->result = "success";
		$retval->err_msg = "";
		$retval->data = new \stdClass();
		$retval->data->popcategories_count = count($categories);
		$retval->data->popcategories = array();
		
		$fontarray = self::getFontAwesomeArray();

		foreach($categories as $category)
		{
			$tmp = new \stdClass();

			$tmp->cat_id = $category->id;
			$tmp->cat_name = $category->categoryname;
			$tmp->cat_photo = $category->category_photo;
			if ($tmp->cat_photo != "" && array_key_exists($tmp->cat_photo, $fontarray))
				$tmp->cat_code = $fontarray[$tmp->cat_photo];
			else
				$tmp->cat_code = "";

			array_push($retval->data->popcategories, $tmp);
		}

		$retval->data->popbusinesses_count = count($businesses);
		$retval->data->popbusinesses = array();
		foreach($businesses as $business)
		{
			$tmp = new \stdClass();

			$tmp->b_id = $business->b_id;
			$tmp->b_title = $business->b_title;
			$tmp->b_catname = $business->b_category;
			$tmp->b_image = $business->b_image;

			array_push($retval->data->popbusinesses, $tmp);
		}
		
		return response()->json($retval);
	}

	public function categorylist(Request $request){
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

		$categories = DB::table('category')->get();

		$fontarray = self::getFontAwesomeArray();
		
		$retval->result = "success";
		$retval->err_msg = "";
		$retval->data = new \stdClass();
		$retval->data->category_count = count($categories);
		$retval->data->categories = array();

		foreach($categories as $category)
		{
			$tmp = new \stdClass();
			$tmp->cat_id = $category->id;
			$tmp->cat_name = $category->categoryname;
			$tmp->cat_photo = $category->category_photo;
			if ($tmp->cat_photo != "" && array_key_exists($tmp->cat_photo, $fontarray))
				$tmp->cat_code = $fontarray[$tmp->cat_photo];
			else
				$tmp->cat_code = "";
			array_push($retval->data->categories, $tmp);
		}

		return response()->json($retval);
	}
	
	public function getFontAwesomeArray()
	{
		$pattern = '/\.(fa-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"\\\\(.+)";\s+}/';
		$subject =  file_get_contents('lib1/css/font-awesome.css');
		preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
		foreach($matches as $match) {
			$icons[$match[1]] = "&#x".$match[2];
		}
		return $icons;
	}
}