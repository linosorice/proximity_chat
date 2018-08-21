<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\City;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getCities(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		if($request->province_name=="") {
			return "";
		}
		
		// lista della città data una provincia
		$cities = City::where('province', $request->province_name)->orderBy('name', 'ASC')->get();
		
		return json_encode($cities, true);
    }
}
