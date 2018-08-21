<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\QrC;
use App\Company;
use App\Store;
use QrCode;

class QrCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function index()
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// lista stores associati al proprio account
		$stores_id = array();
		foreach(Auth::user()->companies as $company) {
			foreach($company->stores as $store) {
				$stores_id[] = $store->id;
			}
		}
		
		// lista qrcodes degli store
		$qrcodes = QrC::whereIn('store_id', $stores_id)->where('is_removed', 0)->orderBy('created_at', 'DESC')->get();
		
		return view('qrcode.index', ['qrcodes' => $qrcodes]);
    }
	
    public function create()
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// lista stores associati al proprio account
		$stores_id = array();
		foreach(Auth::user()->companies as $company) {
			foreach($company->stores as $store) {
				$stores_id[] = $store->id;
			}
		}
		
		// lista store
		$stores = Store::whereIn('id', $stores_id)->where('is_removed', 0)->orderBy('name', 'ASC')->get();
		
		return view('qrcode.create', ['stores' => $stores]);
    }
	
    public function insert(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// inserimento nuovo qrcode
		if($request->code!="" and $request->store_id!="") {
			$qrcode = new QrC();
			$qrcode->store_id = $request->store_id;
			$qrcode->code = $request->code;
			$qrcode->image = $qrcode->code.'.png';
			$qrcode->save();
			
			QrCode::format('png')->size(600)->margin(1)->generate(config('settings.app_url').config('settings.qrcode_path_name').'/'.$qrcode->code, public_path().'/images/qrcodes/'.$qrcode->code.'.png');
			
			return redirect('qrcode')->with('status', ['success', 'Successo', 'QrCode "'.$qrcode->code.'" creato correttamente']);
		}
		
		return redirect('qrcode')->with('status', ['error', 'Attenzione', 'Errore durante la creazione del QrCode']);
    }
	
    public function delete(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		// cancellazione qrcode
		if($request->modal_form_item_id!="") {
			$qrcode = QrC::find($request->modal_form_item_id);
			$qrcode->is_enabled = 0;
			$qrcode->is_removed = 1;
			$qrcode->date_removed = date("Y-m-d H:i:s");
			$qrcode->save();
			
			return redirect('qrcode')->with('status', ['success', 'Successo', 'QrCode "'.$qrcode->code.'" cancellato correttamente']);
		}
		
		return redirect('qrcode')->with('status', ['error', 'Attenzione', 'Errore durante la cancellazione del QrCode']);
    }
	
    public function access(Request $request)
    {
		if(!$this->auth_routes()) return redirect(config('settings.route_redirect_default'));
		
		if($request->code=="") {
			return response()->json(array('message' => 'Code missing'), 403);
		}
		
		$qrcode = QrC::where('code', $request->code)->where('is_removed', 0)->first();
		if(empty($qrcode)) {
			return response()->json(array('message' => 'Code not existing'), 403);
		}
		
		if($qrcode->is_removed==1) {
			return response()->json(array('message' => 'Code not existing'), 403);
		}
		
		if($qrcode->is_enabled==0) {
			return response()->json(array('message' => 'Code not enabled'), 403);
		}
		
		return response()->json(array('message' => 'Ok'), 200);
    }
}
