<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Account;
use App\Company;
use App\Store;
use App\Group;
use App\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	public function index(Request $request)
    {
		// Area Admin
		if(Auth::user()->role_id==1) {
			$companies = Company::where('is_removed', 0)->get();
			$stores = Store::where('is_removed', 0)->get();
			$groups = Group::where('is_removed', 0)->get();
			$users = User::where('is_removed', 0)->get();
			
			$date_signup = User::where('is_removed', 0)->orderBy('created_at', 'ASC')->first();
			
			return view('admin.index', ['companies' => $companies, 'stores'=>$stores, 'groups' => $groups, 'users' => $users, 'date_signup' => $date_signup]);
		}
		
		// Area Company
		else if(Auth::user()->role_id==2) {
			return view('company.index');
		}
    }
	
    public function profile(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		if(empty(Auth::user())) {
			return redirect(config('settings.route_redirect_default'));
		}
		
		// dati account
		$account = Account::find(Auth::user()->id);
		
		return view('profile', ['account' => $account]);
    }
	
    public function updateProfile(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		if(!empty(Auth::user())) {
			$account = Account::find(Auth::user()->id);
			$account->name = $request->name;
			$account->surname = $request->surname;
			if($request->password!="") $account->password = Hash::make($request->password);
				
			$account->save();
			
			return redirect('profile')->with('status', ['success', 'Successo', 'Profilo modificato correttamente']);
		}
		
		return redirect('/')->with('status', ['error', 'Attenzione', 'Errore durante la modifica del Profilo']);
    }
	
    public function help(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// dati account
		$account = Account::find(Auth::user()->id);
		
		return view('help', ['account' => $account]);
    }
	
    public function sendHelp(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		if($request->subject!="" and $request->text!="") {
			
			return redirect('help')->with('status', ['success', 'Successo', 'Richiesta di assistenza inviata correttamente. Verrai contattato al più presto dal Supporto']);
		}
		
		return redirect('/')->with('status', ['error', 'Attenzione', 'Errore durante la richiesta di Assistenza']);
    }
}
