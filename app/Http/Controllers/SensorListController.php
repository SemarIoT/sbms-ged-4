<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\EnergyOutlet;
use App\Models\EnergyOutletMaster;
use App\Models\EnergyPanel;
use App\Models\EnergyPanelMaster;
use App\Models\DhtSensor;
use App\Models\LightDimmer;
use App\Models\Light;
use App\Models\FireAlarm;
use App\Models\Energy;
use App\Models\Camera;
use App\Models\DhtExtra;

class SensorListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
   
    public function index()
    {
        $energy_panel = EnergyPanel::oldest()->Paginate(100);
        $energy_outlet = EnergyOutlet::oldest()->Paginate(100);
        $energy_outlet_master = EnergyOutletMaster::oldest()->Paginate(100);
        $energy_panel_master = EnergyPanelMaster::oldest()->Paginate(100);
        $light = Light::oldest()->paginate(100);
        $lightdimmer = LightDimmer::oldest()->paginate(100);
        $firealarm = FireAlarm::oldest()->paginate(100);
        $camera = Camera::oldest()->paginate(100);
        $dhtx = DhtExtra::oldest()->paginate(100);

        return view ('admin.sensorlist',compact('light','energy_outlet','energy_outlet_master','energy_panel_master','energy_panel','lightdimmer','firealarm','camera','dhtx'))
        ->with('i', (request()->input('page', 1) -1) * 5)
        ->with('j', (request()->input('page', 1) -1) * 5)
        ->with('k', (request()->input('page', 1) -1) * 5)
        ->with('l', (request()->input('page', 1) -1) * 5)
        ->with('m', (request()->input('page', 1) -1) * 5)
        ->with('n', (request()->input('page', 1) -1) * 5)
        ->with('o', (request()->input('page', 1) -1) * 5);
    }
   
}
