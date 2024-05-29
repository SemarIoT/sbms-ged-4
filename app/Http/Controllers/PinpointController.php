<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Light;
use App\Models\Camera;
use App\Models\EnergyPanelMaster;
use App\Models\FireAlarm;
use App\Models\LightDimmer;
use App\Models\Pinpoint;
use App\Models\PinpointMap;

class PinpointController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $light = Pinpoint::where('id_nama','lampu')->oldest()->get();
        $lightdimmer = Pinpoint::where('id_nama','dimmer')->oldest()->get();
        $energypanelmaster = Pinpoint::where('id_nama','panel')->oldest()->get();
        $firealarm = Pinpoint::where('id_nama','fire')->oldest()->get();
        $camera = Pinpoint::where('id_nama','camera')->oldest()->get();
        $dht = Pinpoint::where('id_nama','dht')->oldest()->get();
        $map = PinpointMap::latest()->paginate(1);
        
        //$lightposition = Pinpoint::where('nama','lampu')

        return view('pin-point3show',
               compact('light',
                        'lightdimmer',
                        'energypanelmaster',
                        'firealarm',
                        'camera',
                        'dht',
                        'map'
                    ));
    }
    public function pinpointset(){
        $light = Pinpoint::where('id_nama','lampu')->oldest()->get();
        $lightdimmer = Pinpoint::where('id_nama','dimmer')->oldest()->get();
        $energypanelmaster = Pinpoint::where('id_nama','panel')->oldest()->get();
        $firealarm = Pinpoint::where('id_nama','fire')->oldest()->get();
        $camera = Pinpoint::where('id_nama','camera')->oldest()->get();
        $dht = Pinpoint::where('id_nama','dht')->oldest()->get();
        $map = PinpointMap::latest()->paginate(1);
        //$lightposition = Pinpoint::where('nama','lampu')

        return view('pin-point3',
               compact('light',
                        'lightdimmer',
                        'energypanelmaster',
                        'firealarm',
                        'camera',
                        'dht',
                        'map'
                    ));
    }

    public function updatePinpoint(Request $request){
        
        $id = $request->get('id'); 
        $xpos = $request->get('x-edit');
        $ypos = $request->get('y-edit');
        
        
        $data = Pinpoint::where('id',$id)->update(array(
        'xpos' => $xpos,
        'ypos' => $ypos,
        
        ));

        return redirect('pinpointset');
    }
    public function deletepinpoint($id){
		$data = Pinpoint::findorfail($id);
		$data->delete();

        return redirect('pinpointset');
	}
    public function storepinpoint(Request $request){
       
        request()->validate(
            [
                'nama'=> 'required',
                'id_nama'=> 'required',
                'xpos'=> 'required',
                'ypos'=> 'required',
                
                
            ]);

        $data = new Pinpoint;
        $data->nama = $request->nama;
        $data->id_nama = $request->id_nama;
        $data->xpos = $request->xpos;
        $data->ypos = $request->ypos;       
        $data->save();

        return redirect('pinpointset');
    }
}
