<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DhtSensor;
use App\Models\DhtExtra;
use App\Models\DhtExtraData;
use DB;
use Carbon\Carbon;

use App\Exports\DhtExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use App\Models\Driver;


class DhtSensorTemperatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
        public function index(){
       
        $temperature = DhtSensor::latest()->paginate(1);
        $tempx1 = DhtExtraData::where('dht', 'DHT1')->latest()->paginate(1);
        $tempx2 = DhtExtraData::where('dht', 'DHT2')->latest()->paginate(1);
        $tempx3 = DhtExtraData::where('dht', 'DHT3')->latest()->paginate(1);
        $tempx4 = DhtExtraData::where('dht', 'DHT4')->latest()->paginate(1);
        $tempx5 = DhtExtraData::where('dht', 'DHT5')->latest()->paginate(1);
        $dhtx1 = DhtExtra::where('id_nama', 'DHT1')->latest()->paginate(1);
        $dhtx2 = DhtExtra::where('id_nama', 'DHT2')->latest()->paginate(1);
        $dhtx3 = DhtExtra::where('id_nama', 'DHT3')->latest()->paginate(1);
        $dhtx4 = DhtExtra::where('id_nama', 'DHT4')->latest()->paginate(1);
        $dhtx5 = DhtExtra::where('id_nama', 'DHT5')->latest()->paginate(1);
        
        return view('environment.temperature', compact('temperature','tempx1','tempx2','tempx3','tempx4','tempx5','dhtx1','dhtx2','dhtx3','dhtx4','dhtx5'));
      
    }
    public function export_excel()
	{
		return Excel::download(new DhtExport, 'temperature.xlsx');
	}
    public function export_excel_csv()
	{
		return Excel::download(new DhtExport, 'temperature.csv');
	}
    
    
     
}