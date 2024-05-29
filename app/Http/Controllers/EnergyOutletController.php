<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EnergyOutlet;
use App\Models\EnergyOutletMaster;
use App\Models\EnergyPanel;
use App\Models\EnergyPanelMaster;
use App\Models\Light;
use App\Models\LightMaster;

class EnergyOutletController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showData()
    {
        $energy_panel_master = EnergyPanelMaster::oldest()->Paginate(10);
        $energy_panel = EnergyPanel::oldest()->Paginate(10);
        $lights = Light::latest()->Paginate(4);

        return view('energy.control', compact('energy_panel_master', 'energy_panel', 'lights'));
    }
    public function changePanelMaster($id)
    {
        $getStatus = EnergyPanelMaster::select('status')->where('id', $id)->first();
        if ($getStatus->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        EnergyPanelMaster::where('id', $id)->update(['status' => $status]);
        EnergyOutletMaster::query()->update(['status' => $status]);
        EnergyOutlet::query()->update(['status' => $status]);
        EnergyPanel::query()->update(['status' => $status]);
        Light::query()->update(['status' => $status]);
        LightMaster::query()->update(['status' => $status]);
        return back();
    }

    public function changeOutletMaster($id)
    {
        $getStatus = EnergyOutletMaster::select('status')->where('id', $id)->first();
        if ($getStatus->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        EnergyOutletMaster::where('id', $id)->update(['status' => $status]);
        EnergyOutlet::query()->update(['status' => $status]);
        return back();
    }

    public function changePanel($id)
    {
        $getStatus = EnergyPanel::where('id', $id)->first();

        if ($getStatus->nama == 'Lampu') {
            if ($getStatus->status == 1) {
                $status = 0;
            } else {
                $status = 1;
            }
            EnergyPanel::where('id', $id)->update(['status' => $status]);
            LightMaster::where('id', 1)->update(['status' => $status]);
            return back();
        } else {
            if ($getStatus->status == 1) {
                $status = 0;
            } else {
                $status = 1;
            }
            EnergyPanel::where('id', $id)->update(['status' => $status]);
            return back();
        }
    }

    public function changeOutlet($id)
    {
        $getStatus = EnergyOutlet::select('status')->where('id', $id)->first();
        if ($getStatus->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        EnergyOutlet::where('id', $id)->update(['status' => $status]);
        return back();
    }
}
