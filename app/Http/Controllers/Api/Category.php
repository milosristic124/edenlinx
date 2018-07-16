<?php

namespace App\Http\Controllers\Api;


use DB;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class Category extends Controller
{

    public function __construct()
    {
        $this->middleware('jwt.auth');
    }
    
    public function index(Request $request)
    {
    	try {

    		$data = $request->all();

    		$user = JWTAuth::parseToken()->authenticate();

    		$query = DB::table('category');

    		if(isset($data['limit']))
    			$query->limit($data['limit']);

    		if(isset($data['offset']))
    			$query->offset( $data['offset']);

    		if(isset($data['page'])){

    			$limit = 15;

    			if(!isset($data['limit']))
    				$query->limit($limit);
    			else
    				$limit = $data['limit'];

    			$query->offset( ($data['page'] -1) * $limit );
    		}

    		if(isset($data['q']));
    		
    		if(isset($data['name'])){

    			$query->where('categoryname', 'like', '%'.$data['name'].'%');
    		}

    		$query = $query->get();

    		return response()->json($query);
    	} catch (Exception $e) {
    		return response()->json(['errors' => $e->getMessage()], Response::HTTP_CONFLICT);
    	}
    }
    
    public function create(Request $request)
    {
        try {

    		$data = $request->all();

    		$validator = Validator::make($data, [
			    'name' => 'required|string|min:5'
			]);

			if ($validator->fails())
			    return response()->json(['errors' => $validator->messages()], Response::HTTP_UNPROCESSABLE_ENTITY);

    		$user = JWTAuth::parseToken()->authenticate();

    		$category = [
    			'categoryname' => $data['name']
    		];

    		$category['id'] =  DB::table('category')->insertGetId($category);
    		return response()->json($category);
    	} catch (Exception $e) {
    		return response()->json(['errors' => $e->getMessage()], Response::HTTP_CONFLICT);
    	}
    }

    public function show(Request $request, $id)
    {
      	try{
      		$data = $request->all();

	        $query = DB::table('category');

	        if(isset($data['fields'])){
	        	$query->select(explode(',', $data['fields']));
	        }

	        $query->where('id', $id);

	        $query = $query->first();

	        return response()->json($query);
	    } catch (Exception $e) {
    		return response()->json(['errors' => $e->getMessage()], Response::HTTP_CONFLICT);
    	}
    }

    public function update(Request $request, $id)
    {
        try {

    		$data = $request->all();

			if (empty($id) || !is_int($id))
			    return response()->json(['errors' => 'no model'], Response::HTTP_UNPROCESSABLE_ENTITY);

    		$user = JWTAuth::parseToken()->authenticate();

    		$category = Db::table('category')->where('id', $id)->first();

    		if(!$category)
    			return response()->json(['errors' => 'model not found'], Response::HTTP_UNPROCESSABLE_ENTITY);

    		if($user->id != $category->userid)
    			return response()->json(['errors' => 'Forbidden'], Response::HTTP_UNAUTHORIZED);
    			

			$status = DB::table('category')->where('b_id', $id)
				->update([
	    			'categoryname' => isset($data['name'])? $data['name'] : $category->categoryname
	    		]);

    		return response()->json(['status' => $status]);
    	} catch (Exception $e) {
    		return response()->json(['errors' => $e->getMessage()], Response::HTTP_CONFLICT);
    	}
    }
    public function destroy($id)
    {
        try {

    		$user = JWTAuth::parseToken()->authenticate();

    		$category = Db::table('category')->where('id', $id)->first();

    		if(!$category)
    			return response()->json(['errors' => 'model not found'], Response::HTTP_UNPROCESSABLE_ENTITY);

    		if($user->id != $category->userid)
    			return response()->json(['errors' => 'Forbidden'], Response::HTTP_UNAUTHORIZED);
    		

			$status = DB::table('category')->where('id', $id)->delete();

    		return response()->json(['status' => $status]);
    	} catch (Exception $e) {
    		return response()->json(['errors' => $e->getMessage()], Response::HTTP_CONFLICT);
    	}
    }

    public function search()
    {
        echo 'search';
    }
}