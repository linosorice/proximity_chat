<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Company;
use App\User;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('api_authorization');
    }
	
	// [POST] User Api: loginUser
	// /api/v1/users/login
    public function loginUser(Request $request)
    {
		if(!isset($request->email) or $request->email=="") {
			return response()->json(apiResult(null, "Email missing"), 403);
		}
		
		if(!isset($request->password) or $request->password=="") {
			return response()->json(apiResult(null, "Password missing"), 403);
		}
		
		$email = trim(strtolower($request->email));
		$password = trim(strtolower($request->password));
		
		$user = User::where('email', $email)->where('is_removed', 0)->first();
		if(!(!empty($user) and Hash::check($password, $user->password))) {
			return response()->json(apiResult(null, "User not existing"), 403);
		}
		
		// output data array
		$output_array = array(
			'user_id' => intval($user->id),
		);
		
		return response()->json(apiResult($output_array, "User login done successfully"), 200);
    }

	// [GET] User Api: getUserById
	// /api/v1/users/{user_id}
    public function getUserById(Request $request)
    {
		if($request->user_id=="") {
			return response()->json(apiResult(null, "User Id missing"), 403);
		}
		
		$user = User::where('id', $request->user_id)->where('is_removed', 0)->first();
		if(empty($user)) {
			return response()->json(apiResult(null, "User Id missing"), 403);
		}
		
		// output data array
		$output_array = $this->getUserData($request, $user);
		
		return response()->json(apiResult($output_array, "User Data sent successfully"), 200);
    }
	
	// [GET] User Api: getUsers
	// /api/v1/users/list
    public function getUsers(Request $request)
    {
		$users = User::where('is_removed', 0)->orderBy('id', 'ASC')->get();
		if(empty($users)) {
			return response()->json(apiResult(null, "No registered users"), 403);
		}
		
		// output data array
		$output_array = array();
		foreach($users as $user) {
			$output_array[] = $this->getUserData($request, $user);
		}
		
		return response()->json(apiResult($output_array, "Users List sent successfully"), 200);
    }
	
	
	
	/*
	* Funzioni di supporto
	\* --------------------- */
    private function getUserData(Request $request, $user_result)
    {
		if(!isset($user_result) or empty($user_result) or $user_result=="") {
			return false;
		}
		
		// output data array
		$user_array = array(
			'id' => intval($user_result->id),
			'id_rc' => $user_result->id_rc,
			'name' => $user_result->name,
			'nickname' => $user_result->nickname,
			'email' => $user_result->email,
			'age' => $this->calcAge($user_result->date_of_birth),
			'gender' => $user_result->gender,
			//'relathionship_status' => $user_result->relationship_status->name,
			'avatar' => $user_result->avatar,
			'is_view_name' => $this->intToBoolen($user_result->is_view_name),
			'is_view_age' => $this->intToBoolen($user_result->is_view_age),
			'is_view_gender' => $this->intToBoolen($user_result->is_view_gender),
			'is_agree_private_chat' => $this->intToBoolen($user_result->is_agree_private_chat),
			'is_agree_public_position' => $this->intToBoolen($user_result->is_agree_public_position),
			'created_at' => date("Y-m-d H:i:s", strtotime($user_result->created_at))
		);
		
		return $user_array;
    }
	
	private function intToBoolen($int_value) {
		if($int_value=="" or $int_value=="0")
			return false;
		else if($int_value=="1")
			return true;
	}
	
	private function calcAge($date_of_birth) {
		if($date_of_birth=="") {
			return null;
		}
		
		list($year, $month, $day) = explode("-", $date_of_birth);

		$year_diff  = date("Y") - $year;
		$month_diff = date("m") - $month;
		$day_diff   = date("d") - $day;
		if ($day_diff < 0 || $month_diff < 0)      
			$year_diff--;    

		return intval($year_diff);
	}
}
