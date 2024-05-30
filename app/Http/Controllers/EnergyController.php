<?php

namespace App\Http\Controllers;

use DB;
use App\Models\About;
use App\Models\Light;
use App\Models\Driver;
use App\Models\Energy;
use App\Models\EnergyCost;
use App\Models\EnergyPanel;
use App\Models\LightMaster;
use App\Models\EnergyOutlet;
use Illuminate\Http\Request;
use App\Exports\EnergyExport;
use Illuminate\Support\Carbon;
use App\Models\EnergyPanelMaster;
use App\Models\EnergyOutletMaster;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class EnergyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function monitor()
    {
        $todayDate = Carbon::today()->toDateString(); // return Y-m-d string
        $yesterdayDate = Carbon::now()->subDays(1)->toDateString();
        $thisMonth = Carbon::now()->month; // return int
        $lastMonth = Carbon::now()->month - 1;
        $thisYear = Carbon::now()->year;

        $energies1 = Energy::where('id_kwh', '1')->latest()->first();
        $energies2 = Energy::where('id_kwh', '2')->latest()->first();
        $energies3 = Energy::where('id_kwh', '3')->latest()->first();
        $energies4 = Energy::where('id_kwh', '4')->latest()->first();
        $energyTillNow = $energies1->energy + $energies2->energy + $energies3->energy + $energies4->energy;

        // EnergyToday
        $eachTodayEnergy = collect([]);
        $energyYesterday = 0;
        for ($i = 1; $i <= 4; $i++) {
            try {
                $eachYesterday = Energy::where('id_kwh', $i)->whereDate('created_at', $yesterdayDate)->latest()->first()->energy;
                $eachKwh = Energy::where('id_kwh', $i)->whereDate('created_at', $todayDate)->latest()->first()->energy;
            } catch (\Throwable $th) {
                $eachYesterday = Energy::where('id_kwh', $i)->latest()->first()->energy;
                $eachKwh = Energy::where('id_kwh', $i)->latest()->first()->energy;
            }

            $energyYesterday += $eachYesterday;

            // Energi terbaru hari ini - energi terakhir hari kemarin
            $todayWh = $eachKwh - $eachYesterday;
            // echo ($eachKwh . ' ' . $todayWh . ' ' . '' . $eachYesterday);
            $eachTodayEnergy->push($todayWh);
        }
        $energy_today = ($energyTillNow - $energyYesterday) / 1000;

        // Energy Last Month
        $energyLastMonth = 0;
        for ($i = 1; $i <= 4; $i++) {
            try {
                $eachLastMonth = Energy::where('id_kwh', $i)->whereMonth('created_at', $lastMonth)->whereYear('created_at', $thisYear)->latest()->first()->energy;
            } catch (\Exception $e) {
                // Jika data bulan yang lalu belum ada, maka dianggap 0
                $eachLastMonth = 0;
            }
            $energyLastMonth += $eachLastMonth;
        }

        // Energy This Month
        $energy_month = ($energyTillNow - $energyLastMonth) / 1000;
        $energies = [];
        $energyLastMonth = $energyLastMonth / 1000;

        // Untuk detail tiap kWh mter
        $energies[1] = $energies1;
        $energies[2] = $energies2;
        $energies[3] = $energies3;
        $energies[4] = $energies4;
        $energiesCollection = collect($energies);

        $avgVolt = ($energies1->tegangan + $energies2->tegangan + $energies3->tegangan + $energies4->tegangan) / 4;
        $avgCurrent = ($energies1->arus + $energies2->arus + $energies3->arus + $energies4->arus) / 4;
        $avgFreq = ($energies1->frekuensi + $energies2->frekuensi + $energies3->frekuensi + $energies4->frekuensi) / 4;
        $avgP = ($energies1->active_power + $energies2->active_power + $energies3->active_power + $energies4->active_power) / 4;
        $avgQ = ($energies1->reactive_power + $energies2->reactive_power + $energies3->reactive_power + $energies4->reactive_power) / 4;
        $avgS = ($energies1->apparent_power + $energies2->apparent_power + $energies3->apparent_power + $energies4->apparent_power) / 4;

        $energy_cost = EnergyCost::latest()->first()->harga;
        $energy_cost_pokok = EnergyCost::latest()->first()->pokok;
        $energy_cost_delay = EnergyCost::latest()->first()->delay; // Delay kirim  data

        // Device Status
        $devicesPanel = EnergyPanel::get();

        return view('energy.monitor', compact(
            'energies1',
            'energies1',
            'energies3',
            'energies4',
            'energy_today',
            'energy_month',
            'energy_cost',
            'energy_cost_pokok',
            'energyLastMonth',
            'energy_cost_delay',
            'energiesCollection',
            'avgVolt',
            'avgCurrent',
            'avgFreq',
            'avgP',
            'avgQ',
            'avgS',
            'eachTodayEnergy',
            'devicesPanel'
        ));
    }

    public function energyStat()
    {
        $price = DB::select('SELECT month(energies.created_at)as month,year(energies.created_at)as tahun,SUM(energies.active_power*(energy_costs.delay/3600)) AS result,SUM(energies.active_power*energy_costs.harga) AS harga FROM energies JOIN energy_costs WHERE id_kwh = 1 GROUP BY month(energies.created_at) DESC,year(energies.created_at) DESC');

        // dd($price);
        return view('energy.statistic', compact('price'))->with('i', (request()->input('page', 1) - 1) * 5);
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

    public function export_excel()
    {
        return Excel::download(new EnergyExport, 'energy.xlsx');
    }
    public function export_excel_csv()
    {
        return Excel::download(new EnergyExport, 'energy.csv');
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
