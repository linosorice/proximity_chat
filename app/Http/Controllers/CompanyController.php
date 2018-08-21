<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Company;
use App\City;
use App\Account;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// province
		$provinces = City::distinct('province')->select('province as name')->orderBy('province')->get();
		
		// accounts di tipo company
		$accounts = Account::where('role_id', 2)->where('is_removed', 0)->orderBy('surname', 'ASC')->get();
		
		return view('network.company.create', ['provinces' => $provinces, 'accounts' => $accounts]);
    }
	
    public function insert(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// inserimento nuova company
		if($request->name!="" and $request->city_id!="" and $request->accounts_id!="") {
			$company = new Company();
			$company->name = $request->name;
			$company->city_id = $request->city_id;
			if($request->address!="") $company->address = $request->address;
			if($request->zip_code!="") $company->zip_code = $request->zip_code;
			if($request->phone_number!="") $company->phone_number = $request->phone_number;
			if($request->vat_number!="") $company->vat_number = $request->vat_number;
			if($request->tax_code!="") $company->tax_code = $request->tax_code;
			$company->save();
			
			// associazione accounts
			foreach($request->accounts_id as $account_id) {
				$account = Account::find($account_id);
				$company->accounts()->attach($account);
			}
			
			return redirect('network')->with('status', ['success', 'Successo', 'Company "'.$company->name.'" creata correttamente']);
		}
		
		return redirect('network')->with('status', ['error', 'Attenzione', 'Errore durante la creazione della Company']);
    }
	
    public function delete(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// cancellazione company
		if($request->modal_form_item_id!="") {
			$company = Company::find($request->modal_form_item_id);
			
			// dissociazione accounts
			foreach($company->accounts as $account_value) {
				$account = Account::find($account_value->id);
				$company->accounts()->detach($account);
			}
			
			$company->is_removed = 1;
			$company->date_removed = date("Y-m-d H:i:s");
			$company->save();
			
			// cancellazione di tutti gli store associati alla company
			// ... [DA FARE]
			
			return redirect('network')->with('status', ['success', 'Successo', 'Company "'.$company->name.'" cancellata correttamente']);
		}
		
		return redirect('network')->with('status', ['error', 'Attenzione', 'Errore durante la cancellazione della Company']);
    }
	
    public function edit(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// province
		$provinces = City::distinct('province')->select('province as name')->orderBy('province')->get();
		
		// accounts di tipo company
		$accounts = Account::where('role_id', 2)->where('is_removed', 0)->orderBy('surname', 'ASC')->get();
		
		// dati company
		$company = Company::find($request->company_id);
		$city_data = City::where('id', $company->city_id)->first();
		
		// accounts della company già associati
		$accounts_associated = array();
		foreach($company->accounts as $account_value) {
			$accounts_associated[] = $account_value->id;
		}
		
		return view('network.company.edit', ['company' => $company, 'accounts_associated' => $accounts_associated, 'city_data' => $city_data, 'provinces' => $provinces, 'accounts' => $accounts]);
    }
	
    public function update(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// modifica dati company
		if($request->name!="" and $request->city_id!="" and $request->accounts_id!="") {
			$company = Company::find($request->company_id);
			
			if(!empty($company)) {
				$company->name = $request->name;
				$company->city_id = $request->city_id;
				if($request->address!="") $company->address = $request->address;
				if($request->zip_code!="") $company->zip_code = $request->zip_code;
				if($request->phone_number!="") $company->phone_number = $request->phone_number;
				if($request->vat_number!="") $company->vat_number = $request->vat_number;
				if($request->tax_code!="") $company->tax_code = $request->tax_code;
				$company->save();
				
				// dissociazione accounts
				foreach($company->accounts as $account_value) {
					$account = Account::find($account_value->id);
					$company->accounts()->detach($account);
				}
				
				// associazione nuovi accounts
				foreach($request->accounts_id as $account_id) {
					$account = Account::find($account_id);
					$company->accounts()->attach($account);
				}
				
				return redirect('network')->with('status', ['success', 'Successo', 'Company "'.$company->name.'" modificata correttamente']);
			}
		}
		
		return redirect('network')->with('status', ['error', 'Attenzione', 'Errore durante la modifica della Company']);
    }
}
