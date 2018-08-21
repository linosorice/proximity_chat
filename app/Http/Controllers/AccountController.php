<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Account;
use App\Company;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// liste company
		$accounts = Account::where('role_id', 2)->where('is_removed', 0)->orderBy('name', 'ASC')->get();
		
		return view('network.account.index', ['accounts' => $accounts]);
    }
	
    public function create()
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// lista company
		$companies = Company::where('is_removed', 0)->orderBy('name', 'ASC')->get();
		
		return view('network.account.create', ['companies' => $companies]);
    }
	
    public function insert(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// inserimento nuovo account
		if($request->name!="" and $request->email!="" and $request->password!="" and $request->companies_id) {
			$account = new Account();
			$account->role_id = 2;
			$account->name = $request->name;
			if($request->surname!="") $account->surname = $request->surname;
			$account->email = $request->email;
			$account->password = Hash::make($request->password);
			$account->save();
			
			// associazione companies
			foreach($request->companies_id as $company_id) {
				$company = Company::find($company_id);
				$account->companies()->attach($company);
			}
			
			return redirect('account')->with('status', ['success', 'Successo', 'Account "'.$account->email.'" creato correttamente']);
		}
		
		return redirect('account')->with('status', ['error', 'Attenzione', 'Errore durante la creazione dell\'Account']);
    }
	
    public function delete(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// cancellazione account
		if($request->modal_form_item_id!="") {
			$account = Account::find($request->modal_form_item_id);
			
			// dissociazione companies
			foreach($account->companies as $company_value) {
				$company = Company::find($company_value->id);
				$account->companies()->detach($company);
			}
			
			$account->is_removed = 1;
			$account->date_removed = date("Y-m-d H:i:s");
			$account->save();
			
			return redirect('account')->with('status', ['success', 'Successo', 'Account "'.$account->email.'" cancellato correttamente']);
		}
		
		return redirect('account')->with('status', ['error', 'Attenzione', 'Errore durante la cancellazione dell\'Account']);
    }
	
    public function edit(Request $request)
    {		
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
	
		// lista company
		$companies = Company::where('is_removed', 0)->orderBy('name', 'ASC')->get();
		
		// dati account
		$account = Account::find($request->account_id);
		
		// companies dell'account già associati
		$companies_associated = array();
		foreach($account->companies as $company_value) {
			$companies_associated[] = $company_value->id;
		}
		
		return view('network.account.edit', ['account' => $account, 'companies_associated' => $companies_associated, 'companies' => $companies]);
    }
	
    public function update(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// modifica dati account
		if($request->name!="" and $request->email!="" and $request->companies_id!="") {
			$account = Account::find($request->account_id);
			
			if(!empty($account)) {
				$account->name = $request->name;
				if($request->surname!="") $account->surname = $request->surname; else $account->surname = NULL;
				$account->email = $request->email;
				if($request->password!="") $account->password = Hash::make($request->password);
				$account->save();
				
				// dissociazione companies
				foreach($account->companies as $company_value) {
					$company = Company::find($company_value->id);
					$account->companies()->detach($company);
				}
				
				// associazione nuove companies
				foreach($request->companies_id as $company_id) {
					$company = Company::find($company_id);
					$account->companies()->attach($company);
				}
				
				return redirect('account')->with('status', ['success', 'Successo', 'Account "'.$account->email.'" modificato correttamente']);
			}
		}
		
		return redirect('account')->with('status', ['error', 'Attenzione', 'Errore durante la modifica dell\'Account']);
    }

    public function fastInsert(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// inserimento nuovo account
		if($request->name!="" and $request->email!="" and $request->password!="") {
			$account = new Account();
			$account->role_id = $request->role_id;
			$account->name = $request->name;
			if($request->surname!="") {
				$account->surname = $request->surname;
			}
			$account->email = $request->email;
			$account->password = Hash::make($request->password);
			$account->save();
			
			return json_encode($account, true);
		}
		
		return false;		
    }
}
