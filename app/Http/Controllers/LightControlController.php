<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Light;
use App\Models\DhtSensor;
use App\Models\EnergyPanel;
use App\Models\LightDimmer;
use App\Models\LightMaster;
use Illuminate\Http\Request;

class LightControlController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function showData()
    {
        $data = DhtSensor::latest()->first();
        return view('environment.light', compact('data'));
    }

    public function changeStatus($id)
    {
        $getStatus = Light::select('status')->where('id', $id)->first();
        if ($getStatus->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        Light::where('id', $id)->update(['status' => $status]);
        LightMaster::query()->update(['status' => $status]);

        return back();
    }

    public function changeMasterStatus($id)
    {
        $getStatus = LightMaster::select('status')->where('id', $id)->first();

        if ($getStatus->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        LightMaster::where('id', $id)->update(['status' => $status]);
        Light::query()->update(['status' => $status]);
        LightDimmer::query()->update(['status' => $status]);

        return redirect()->back();
    }

    public function changeDimmerStatus($id)
    {
        $getStatus = LightDimmer::select('status')->where('id', $id)->first();
        if ($getStatus->status == 1) {
            $status = 0;
            LightDimmer::where('id', $id)->update([
                "nilai" => "0"
            ]);
        } else {
            $status = 1;
        }
        LightDimmer::where('id', $id)->update(['status' => $status]);

        return back();
    }
    public function changeDimmerValue(Request $request, $id)
    {

        LightDimmer::where('id', $id)->update([
            "nilai" => $request->nilai
        ]);
    }


    public function storeLightList(Request $request)
    {

        request()->validate(
            [
                'nama' => 'required',
            ]
        );

        $data = new Light;
        $data->nama = $request->nama;
        $data->status = $request->status;

        $data->save();

        return redirect('daftar-sensor');
    }

    public function showLightList($id)
    {
        $lightshow = Light::where('id', $id)->get();
        $about = About::oldest()->get();
        return view('admin.sensor.lightshow', compact('lightshow', 'about'));
    }

    public function updateLightList(Request $request)
    {
        //
        $id = $request->get('id');
        $nama = $request->get('nama-edit');

        $data = Light::where('id', $id)->update(array(
            'nama' => $nama
        ));

        return redirect('daftar-sensor');
    }

    public function deleteLightList($id)
    {
        $data = Light::findorfail($id);
        $data->delete();

        return redirect('daftar-sensor');
    }
    public function editLightList($id)
    {
        $editlight = Light::select('*')
            ->where('id', $id)
            ->get();

        return view('admin.sensor.lightedit', compact('editlight'));
    }



    public function storeLightDimmerList(Request $request)
    {

        request()->validate(
            [
                'nama' => 'required',

            ]
        );

        $data = new LightDimmer;
        $data->nama = $request->nama;
        $data->status = $request->status;
        $data->nilai = $request->nilai;

        $data->save();

        return redirect('daftar-sensor');
    }

    public function showLightDimmerList($id)
    {
        $lightdimmershow = LightDimmer::where('id', $id)->get();
        $about = About::oldest()->get();
        return view('admin.sensor.lightdimmershow', compact('lightdimmershow', 'about'));
    }

    public function updateLightDimmerList(Request $request)
    {
        //
        $id = $request->get('id');
        $nama = $request->get('nama-edit');

        $data = LightDimmer::where('id', $id)->update(array(
            'nama' => $nama
        ));

        return redirect('daftar-sensor');
    }

    public function deleteLightDimmerList($id)
    {
        $data = LightDimmer::findorfail($id);
        $data->delete();

        return redirect('daftar-sensor');
    }
    public function editLightDimmerList($id)
    {
        $editlightdimmer = LightDimmer::select('*')
            ->where('id', $id)
            ->get();

        return view('admin.sensor.lightdimmeredit', compact('editlightdimmer'));
    }
}
