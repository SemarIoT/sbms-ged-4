<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnergyCost;
use App\Models\DhtSensor;
use App\Models\Energy;
use App\Models\DashboardSetting;
use App\Exports\EnergyRawExport;
use App\Exports\DhtRawExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Driver;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $harga = EnergyCost::latest()->paginate(1);
        $dht = DhtSensor::latest()->paginate(1);
        $energy = Energy::latest()->paginate(1);
        $dashboard = DashboardSetting::oldest()->get();
        return view('admin.setting',compact('harga','dht','energy','dashboard'));
    }
    public function updateHarga(Request $request){
        
        $id = $request->get('id'); 
        $pokok = $request->get('harga-edit');
        $delay = $request->get('delay-edit');
        $harga = ($request->get('harga-edit')/(3600/$request->get('delay-edit')));
        
        $data = EnergyCost::where('id',$id)->update(array(
        'harga' => $harga,
        'pokok' => $pokok,
        'delay' => $delay
        ));

        return redirect('setting-admin');
    }

    
    public function editHarga($id){
        $editharga = EnergyCost::select('*')
                    ->where('id', $id)
                    ->get();

        return view('admin.sensor.hargaedit',compact('editharga'));
    }
    public function ubahstatusdashboard($id){
        $getStatus = DashboardSetting::select('status')->where('id',$id)->first();
        
        if($getStatus->status==1){
            $status = 0;
          
        }else{
            $status = 1;
            
        }
        DashboardSetting::where('id',$id)->update(['status'=>$status]);
               
        return redirect()->back();
    }

    public function Dht_export_excel()
	{
		return Excel::download(new DhtRawExport, 'DHT.xlsx');
	}
    public function Dht_export_excel_csv()
	{
		return Excel::download(new DhtRawExport, 'DHT.csv');
	}
    public function truncateDataDht()
	{
		DhtSensor::truncate();
        return back();
	}
    public function Energy_export_excel()
	{
		return Excel::download(new EnergyRawExport, 'Energi_Data.xlsx');
	}
    public function Energy_export_excel_csv()
	{
		return Excel::download(new EnergyRawExport, 'Energi_Data.csv');
	}
    public function truncateDataEnergy()
	{
		Energy::truncate();
        return back();
	}
}
