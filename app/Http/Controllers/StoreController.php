<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Company;
use App\City;
use App\Store;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// liste company
		$companies = Company::where('is_removed', 0)->orderBy('name', 'ASC')->get();
		
		// dati company
		$company_data = Company::find($request->company_id);
		if(empty($company_data)) {
			return redirect('network');
		}
		
		return view('network.store.index', ['companies' => $companies, 'company_data' => $company_data]);
    }
	
    public function create(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// company data
		$company_data = Company::find($request->company_id);
		if(empty($company_data)) {
			return redirect('network');
		}
		
		// province
		$provinces = City::distinct('province')->select('province as name')->orderBy('province')->get();
		
		return view('network.store.create', ['company_data' => $company_data, 'provinces' => $provinces]);
    }
	
    public function insert(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// inserimento nuova company
		if($request->name!="" and $request->city_id!="") {
			$store = new Store();
			
			// store data
			$store->company_id = $request->company_id;
			$store->name = $request->name;
			if($request->description!="") $store->description = $request->description;
			$store->city_id = $request->city_id;
			if($request->address!="") $store->address = $request->address;
			if($request->zip_code!="") $store->zip_code = $request->zip_code;
			if($request->phone_number!="") $store->phone_number = $request->phone_number;
			if($request->email!="") $store->email = $request->email;
			if($request->website!="") $store->website = $request->website;
			
			// upload logo
			if (isset($request->logo_image) and $request->logo_image->isValid()) {
				$destinationPath = public_path()."/".config('settings.images_url');
				$extension = $request->logo_image->getClientOriginalExtension();
				$filename = str_random(24).'.'.$extension;
				$request->logo_image->move($destinationPath, $filename);
				
				$store->logo_image = $filename;
			}
			
			// social
			if($request->profile_facebook!="") $store->profile_facebook = $request->profile_facebook;
			if($request->profile_twitter!="") $store->profile_twitter = $request->profile_twitter;
			if($request->profile_youtube!="") $store->profile_youtube = $request->profile_youtube;
			if($request->profile_instagram!="") $store->profile_instagram = $request->profile_instagram;
			if($request->profile_linkedin!="") $store->profile_linkedin = $request->profile_linkedin;
			if($request->profile_pinterest!="") $store->profile_pinterest = $request->profile_pinterest;
			if($request->profile_tripadvisor!="") $store->profile_tripadvisor = $request->profile_tripadvisor;
			
			$store->save();
			
			return redirect::route('stores_list', $request->company_id)->with('status', ['success', 'Successo', 'Store "'.$store->name.'" creato correttamente']);
		}
		
		return redirect::route('stores_list', $request->company_id)->with('status', ['error', 'Attenzione', 'Errore durante la creazione dello Store']);
    }
	
    public function delete(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// cancellazione company
		if($request->modal_form_item_id!="") {
			$store = Store::find($request->modal_form_item_id);
			$store->is_removed = 1;
			$store->date_removed = date("Y-m-d H:i:s");
			$store->save();
			
			// cancellazione di tutti i gruppi associati allo store
			// ... [DA FARE]
			
			return redirect::route('stores_list', $store->company_id)->with('status', ['success', 'Successo', 'Store "'.$store->name.'" cancellato correttamente']);
		}
		
		return redirect::route('stores_list', $store->company_id)->with('status', ['error', 'Attenzione', 'Errore durante la cancellazione dello Store']);
    }
	
    public function edit(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// province
		$provinces = City::distinct('province')->select('province as name')->orderBy('province')->get();
		
		// dati store
		$store = Store::find($request->store_id);
		$city_data = City::where('id', $store->city_id)->first();
		$company_data = Company::find($store->company_id);
		
		return view('network.store.edit', ['store' => $store, 'city_data' => $city_data, 'provinces' => $provinces, 'company_data' => $company_data]);
    }
	
    public function update(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// modifica dati store
		if($request->name!="" and $request->city_id!="") {
			$store = Store::find($request->store_id);
			
			if(!empty($store)) {
				$store->name = $request->name;
				if($request->description!="") $store->description = $request->description; else $store->description = NULL;
				$store->city_id = $request->city_id;
				if($request->address!="") $store->address = $request->address; else $store->address = NULL;
				if($request->zip_code!="") $store->zip_code = $request->zip_code; else $store->zip_code = NULL;
				if($request->phone_number!="") $store->phone_number = $request->phone_number; else $store->phone_number = NULL;
				if($request->email!="") $store->email = $request->email; else $store->email = NULL;
				if($request->website!="") $store->website = $request->website; else $store->website = NULL;
				
				// cancellazione foto esistente
				if($request->remove_image==1 and $store->logo_image!=NULL) {
					unlink(public_path()."/".config('settings.images_url')."/".$store->logo_image);
					$store->logo_image = NULL;
				}
				
				// upload logo
				if (isset($request->logo_image) and $request->logo_image->isValid()) {
					// eliminazione eventuale foto precedente già memorizzata
					if($store->logo_image!=NULL) {
						unlink(public_path()."/".config('settings.images_url')."/".$store->logo_image);
					}
					
					$destinationPath = public_path()."/".config('settings.images_url');
					$extension = $request->logo_image->getClientOriginalExtension();
					$filename = str_random(24).'.'.$extension;
					$request->logo_image->move($destinationPath, $filename);
					
					$store->logo_image = $filename;
				}
				
				// social
				if($request->profile_facebook!="") $store->profile_facebook = $request->profile_facebook; else $store->profile_facebook = NULL;
				if($request->profile_twitter!="") $store->profile_twitter = $request->profile_twitter; else $store->profile_twitter = NULL;
				if($request->profile_youtube!="") $store->profile_youtube = $request->profile_youtube; else $store->profile_youtube = NULL;
				if($request->profile_instagram!="") $store->profile_instagram = $request->profile_instagram; else $store->profile_instagram = NULL;
				if($request->profile_linkedin!="") $store->profile_linkedin = $request->profile_linkedin; else $store->profile_linkedin = NULL;
				if($request->profile_pinterest!="") $store->profile_pinterest = $request->profile_pinterest; else $store->profile_pinterest = NULL;
				if($request->profile_tripadvisor!="") $store->profile_tripadvisor = $request->profile_tripadvisor; else $store->profile_tripadvisor = NULL;

				$store->save();
				
				return redirect::route('stores_list', $store->company_id)->with('status', ['success', 'Successo', 'Store "'.$store->name.'" modificato correttamente']);
			}
		}
		
		return redirect::route('stores_list', $store->company_id)->with('status', ['error', 'Attenzione', 'Errore durante la modifica dello Store']);
    }	
}
