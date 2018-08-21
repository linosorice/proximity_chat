<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Beacon;
use App\Store;

class BeaconController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// lista beacon
		$beacon = Beacon::where('is_removed', 0)->orderBy('uuid', 'ASC')->get();
		
		return view('beacon.index', ['beacon' => $beacon]);
    }
	
    public function create()
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// lista store
		$stores = Store::where('is_removed', 0)->orderBy('name', 'ASC')->get();
		
		return view('beacon.create', ['stores' => $stores]);
    }
	
    public function insert(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// associazione nuovo beacon
		if($request->uuid!="" and $request->store_id!="") {
			$beacon = new Beacon();
			$beacon->name = $request->name;
			$beacon->uuid = $request->uuid;
			if($request->major!="") $beacon->major = $request->major;
			if($request->minor!="") $beacon->minor = $request->minor;
			$beacon->store_id = $request->store_id;
			$beacon->save();
			
			return redirect('beacon')->with('status', ['success', 'Successo', 'Beacon "'.$beacon->uuid.'" creato correttamente']);
		}
		
		return redirect('beacon')->with('status', ['error', 'Attenzione', 'Errore durante la creazione del Beacon']);
    }
	
    public function delete(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// cancellazione beacon
		if($request->modal_form_item_id!="") {
			$beacon = Beacon::find($request->modal_form_item_id);
			$beacon->is_enabled = 0;
			$beacon->is_removed = 1;
			$beacon->date_removed = date("Y-m-d H:i:s");
			$beacon->save();
			
			return redirect('beacon')->with('status', ['success', 'Successo', 'Beacon "'.$beacon->uuid.'" cancellato correttamente']);
		}
		
		return redirect('beacon')->with('status', ['error', 'Attenzione', 'Errore durante la cancellazione del Beacon']);
    }
	
    public function edit(Request $request)
    {		
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
	
		// lista store
		$stores = Store::where('is_removed', 0)->orderBy('name', 'ASC')->get();
		
		// dati account
		$beacon = Beacon::find($request->beacon_id);
		
		return view('beacon.edit', ['stores' => $stores, 'beacon' => $beacon]);
    }
	
    public function update(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// modifica dati beacon
		if($request->store_id!="") {
			$beacon = Beacon::find($request->beacon_id);
			
			if(!empty($beacon)) {
				$beacon->name = $request->name;
				if($request->major!="") $beacon->major = $request->major; else $beacon->major = NULL;
				if($request->minor!="") $beacon->minor = $request->minor; else $beacon->minor = NULL;
				$beacon->store_id = $request->store_id;
				if($request->is_enabled=="1") $beacon->is_enabled = 1; else $beacon->is_enabled = 0;
				$beacon->save();
				
				return redirect('beacon')->with('status', ['success', 'Successo', 'Beacon "'.$beacon->uuid.'" modificato correttamente']);
			}
		}
		
		return redirect('beacon')->with('status', ['error', 'Attenzione', 'Errore durante la modifica del Beacon']);
    }	
}
