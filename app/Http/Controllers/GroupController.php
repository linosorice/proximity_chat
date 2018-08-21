<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Group;
use App\Store;
use App\Beacon;
use App\QrC;

class GroupController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// lista gruppi
		$groups = Group::where('is_removed', 0)->orderBy('name', 'ASC')->get();
		
		return view('group.index', ['groups' => $groups]);
    }
	
    public function create()
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// lista store
		$stores = Store::where('is_removed', 0)->orderBy('name', 'ASC')->get();
		
		return view('group.create', ['stores' => $stores]);
    }
	
    public function insert(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// inserimento nuovo gruppo
		if($request->name!="") {
			$group = new Group();
			$group->name = $request->name;
			
			if($request->type=="free") {
				$group->latitude = $request->latitude;
				$group->longitude = $request->longitude;
			} else if($request->type=="premium") {
				$group->store_id = $request->store_id;
			}
			
			// integrazione Rocket Chat
			$response = createGroup($request, clearString($request->name));
			$group->id_rc = $response->group->_id;
			
			$group->save();
			
			return redirect('group')->with('status', ['success', 'Successo', 'Gruppo "'.$group->name.'" creato correttamente']);
		}
		
		return redirect('group')->with('status', ['error', 'Attenzione', 'Errore durante la creazione del Gruppo']);
    }
	
    public function delete(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// cancellazione gruppo
		if($request->modal_form_item_id!="") {
			$group = Group::find($request->modal_form_item_id);
			$group->is_enabled = 0;
			$group->is_removed = 1;
			$group->date_removed = date("Y-m-d H:i:s");
			$group->save();
			
			// integrazione Rocket Chat
			$response = closeGroup($request, $group->id_rc);
			
			return redirect('group')->with('status', ['success', 'Successo', 'Gruppo "'.$group->name.'" cancellato correttamente']);
		}
		
		return redirect('group')->with('status', ['error', 'Attenzione', 'Errore durante la cancellazione del Gruppo']);
    }
	
    public function edit(Request $request)
    {		
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
	
		// lista store
		$stores = Store::where('is_removed', 0)->orderBy('name', 'ASC')->get();
		
		// dati gruppo
		$group = Group::find($request->group_id);
		
		return view('group.edit', ['group' => $group, 'stores' => $stores]);
    }
	
    public function update(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// modifica dati gruppo
		if($request->name!="") {
			$group = Group::find($request->group_id);
			
			if(!empty($group)) {
				$group->name = $request->name;
				
				if($request->type=="free") {
					$group->latitude = $request->latitude;
					$group->longitude = $request->longitude;
					$group->store_id = NULL;
				} else if($request->type=="premium") {
					$group->store_id = $request->store_id;
					$group->latitude = NULL;
					$group->longitude = NULL;
				}
				
				// integrazione Rocket Chat
				$response = renameGroup($request, $group->id_rc, clearString($request->name));
				
				$group->save();
				
				return redirect('group')->with('status', ['success', 'Successo', 'Gruppo "'.$group->name.'" modificato correttamente']);
			}
		}
		
		return redirect('group')->with('status', ['error', 'Attenzione', 'Errore durante la modifica del Gruppo']);
    }
	
    public function settings(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// dati gruppo
		$group = Group::find($request->group_id);
		
		// dati store
		$store = Store::find($group->store_id);
		
		// beacons già associati al gruppo
		$beacons_associated = array();
		foreach($group->beacons as $beacon) {
			$beacons_associated[] = $beacon->id;
		}
		
		// qrcodes già associati al gruppo
		$qrcodes_associated = array();
		foreach($group->qrcodes as $qrcode) {
			$qrcodes_associated[] = $qrcode->id;
		}
		
		return view('group.settings', ['group' => $group, 'store' => $store, 'beacons_associated' => $beacons_associated, 'qrcodes_associated' => $qrcodes_associated]);
    }
	
    public function updateSettings(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// modifica impostazioni gruppo
		if($request->group_id!="") {
			$group = Group::find($request->group_id);
			
			if(!empty($group)) {
				if($request->is_enabled==1) $group->is_enabled = $request->is_enabled; else $group->is_enabled = 0;
				
				if($request->access_distance==1 and $request->access_distance_range!="" and $request->access_distance_range>0) {
					$group->access_distance_range = $request->access_distance_range;
				} else {
					$group->access_distance_range = NULL;
				}
				
				// dissociazione beacons
				foreach($group->beacons as $beacon_value) {
					$beacon = Beacon::find($beacon_value->id);
					$group->beacons()->detach($beacon);
				}
				if($request->access_beacons==1) {
					// associazione nuove companies
					foreach($request->beacons_id as $beacon_id) {
						$beacon = Beacon::find($beacon_id);
						$group->beacons()->attach($beacon);
					}
				}
				
				// dissociazione qrcodes
				foreach($group->qrcodes as $qrcode_value) {
					$qrcode = QrC::find($qrcode_value->id);
					$group->qrcodes()->detach($qrcode);
				}
				if($request->access_qrcodes==1) {
					// associazione nuove companies
					foreach($request->qrcodes_id as $qrcode_id) {
						$qrcode = QrC::find($qrcode_id);
						$group->qrcodes()->attach($qrcode);
					}
				}
				
				if($request->time_start==$request->time_end) {
					$group->time_start = NULL;
					$group->time_end = NULL;
				} else {
					$group->time_start = $request->time_start;
					$group->time_end = $request->time_end;
				}
				
				$group->save();
				
				return redirect('/')->with('status', ['success', 'Successo', 'Impostazioni del Gruppo "'.$group->name.'" modificate correttamente']);
			}
		}
		
		return redirect('/')->with('status', ['error', 'Attenzione', 'Errore durante la modifica delle impostazioni del Gruppo']);
    }
}
