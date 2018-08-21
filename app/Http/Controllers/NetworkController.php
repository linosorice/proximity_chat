<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Company;

class NetworkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// liste company
		$companies = Company::where('is_removed', 0)->orderBy('name', 'ASC')->get();
		
		return view('network.index', ['companies' => $companies]);
    }
}
