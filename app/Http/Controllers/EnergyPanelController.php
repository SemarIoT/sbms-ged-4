<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Light;
use App\Models\EnergyPanel;
use App\Models\LightMaster;
use App\Models\EnergyOutlet;
use Illuminate\Http\Request;
use App\Models\EnergyPanelMaster;
use App\Models\EnergyOutletMaster;
use App\Http\Controllers\Controller;

class EnergyPanelController extends Controller
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

        if ($getStatus->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        EnergyPanel::where('id', $id)->update(['status' => $status]);
        return back();
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

    //panel list
    public function storePanelList(Request $request)
    {

        request()->validate(
            [
                'nama' => 'required',

            ]
        );

        $data = new EnergyPanel;
        $data->nama = $request->nama;
        $data->status = $request->status;

        $data->save();

        return redirect('daftar-sensor');
    }

    public function showPanelList($id)
    {
        $panelshow = EnergyPanel::where('id', $id)->get();
        $about = About::oldest()->get();
        return view('admin.sensor.panelshow', compact('panelshow', 'about'));
    }

    public function updatePanelList(Request $request)
    {
        //
        $id = $request->get('id');
        $nama = $request->get('nama-edit');

        $data = EnergyPanel::where('id', $id)->update(array(
            'nama' => $nama
        ));

        return redirect('daftar-sensor');
    }

    public function deletePanelList($id)
    {
        $data = EnergyPanel::findorfail($id);
        $data->delete();

        return redirect('daftar-sensor');
    }
    public function editPanelList($id)
    {
        $editpanel = EnergyPanel::select('*')
            ->where('id', $id)
            ->get();

        return view('admin.sensor.paneledit', compact('editpanel'));
    }

    //outlet list
    public function storeOutletList(Request $request)
    {

        request()->validate(
            [
                'nama' => 'required',

            ]
        );

        $data = new EnergyOutlet;
        $data->nama = $request->nama;
        $data->status = $request->status;

        $data->save();

        return redirect('daftar-sensor');
    }

    public function showOutletList($id)
    {
        $outletshow = EnergyOutlet::where('id', $id)->get();
        $about = About::oldest()->get();
        return view('admin.sensor.outletshow', compact('outletshow', 'about'));
    }

    public function updateOutletList(Request $request)
    {
        //
        $id = $request->get('id');
        $nama = $request->get('nama-edit');

        $data = EnergyOutlet::where('id', $id)->update(array(
            'nama' => $nama
        ));

        return redirect('daftar-sensor');
    }

    public function deleteOutletList($id)
    {
        $data = EnergyOutlet::findorfail($id);
        $data->delete();

        return redirect('daftar-sensor');
    }
    public function editOutletList($id)
    {
        $editoutlet = EnergyOutlet::select('*')
            ->where('id', $id)
            ->get();

        return view('admin.sensor.outletedit', compact('editoutlet'));
    }
    public function showOutletMasterList($id)
    {
        $outletshow = EnergyOutletMaster::where('id', $id)->get();
        $about = About::oldest()->get();
        return view('admin.sensor.outletmastershow', compact('outletshow', 'about'));
    }
    public function showPanelMasterList($id)
    {
        $outletshow = EnergyPanelMaster::where('id', $id)->get();
        $about = About::oldest()->get();
        return view('admin.sensor.panelmastershow', compact('outletshow', 'about'));
    }
}
