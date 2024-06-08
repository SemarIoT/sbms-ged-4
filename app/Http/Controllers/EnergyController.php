<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Light;
use App\Models\Energy;
use App\Models\EnergyKwh;
use App\Models\EnergyCost;
use App\Models\EnergyPanel;
use App\Exports\EnergyExport;
use Illuminate\Support\Carbon;
use App\Models\EnergyPanelMaster;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class EnergyController extends Controller
{
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
                $eachYesterday = EnergyKwh::where('id_kwh', $i)->whereDate('created_at', $yesterdayDate)->latest()->first()->energy;
                $eachKwh = EnergyKwh::where('id_kwh', $i)->whereDate('created_at', $todayDate)->latest()->first()->energy;
            } catch (\Throwable $th) {
                // Jika today data tidak ada, maka ambil data terakhir yang ada
                $eachYesterday = EnergyKwh::where('id_kwh', $i)->latest()->first()->energy;
                $eachKwh = EnergyKwh::where('id_kwh', $i)->latest()->first()->energy;
            }

            $energyYesterday += $eachYesterday;

            $todayWh = $eachKwh - $eachYesterday;
            $eachTodayEnergy->push($todayWh);
        }
        $energy_today = ($energyTillNow - $energyYesterday) / 1000;

        // Energy Last Month
        $energyLastMonth = 0;
        for ($i = 1; $i <= 4; $i++) {
            try {
                $eachLastMonth = EnergyKwh::where('id_kwh', $i)->whereMonth('created_at', $lastMonth)->whereYear('created_at', $thisYear)->latest()->first()->energy;
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

    public function control()
    {
        $energy_panel = EnergyPanel::oldest()->get();

        return view('energy.control', compact('energy_panel'));
    }

    public function stats()
    {
        // Biaya bulanan hanya untuk kWh 4 (master)
        $monthlyKwh = $this->getMonthlyEnergy(4);
        // dd($monthlyKwh);

        return view('energy.statistic', compact('monthlyKwh'));
    }

    public function getDailyEnergy($id)
    {
        if ($id > 4) {
            abort(404);
        }

        $data = EnergyKwh::selectRaw('DATE(created_at) as date, MAX(created_at) as latest_updated')
            ->where('id_kwh', '=', $id)
            ->groupBy('id_kwh', 'date')
            ->latest('latest_updated')
            ->get();

        foreach ($data as $item) {
            $energy = EnergyKwh::select('total_energy')
                ->where('id_kwh', $id)
                ->whereDate('created_at', $item->date)
                ->latest('created_at')
                ->first();

            $item->energy_meter = $energy->total_energy;
        }

        $length = count($data);

        for ($i = 0; $i < $length - 1; $i++) {
            $data[$i]->today_energy = $data[$i]->energy_meter - $data[$i + 1]->energy_meter;
            $angka_ike = number_format($data[$i]->today_energy * 30 / 1000 / 33.1, 2); // dikali 30 agar memakai standar perbulan | 33,1 luas ruangan IoT
            $data[$i]->angka_ike = $angka_ike;
            switch ($angka_ike) {
                case $angka_ike <= 7.92:
                    $ike = 'Sangat Efisien';
                    $color = '#00ff00';
                    break;
                case $angka_ike > 7.92 && $angka_ike <= 12.08:
                    $ike = 'Efisien';
                    $color = '#009900';
                    break;
                case $angka_ike > 12.08 && $angka_ike <= 14.58:
                    $ike = 'Cukup Efisien';
                    $color = '#ffff00';
                    break;
                case $angka_ike > 14.58 && $angka_ike <= 19.17:
                    $ike = 'Agak Boros';
                    $color = '#ff9900';
                    break;
                case $angka_ike > 19.17 && $angka_ike <= 23.75:
                    $ike = 'Boros';
                    $color = '#ff3300';
                    break;
                default:
                    $ike = 'Sangat Boros';
                    $color = '#800000';
                    break;
            }
            $data[$i]->ike = $ike;
            $data[$i]->color = $color;
        }

        // Remove the last item from the collection since there is no next day for the last day
        $data->pop();

        return $data;
    }

    public function getDailyEnergyReversed($id)
    {
        if ($id > 4) {
            abort(404);
        }
        $data = EnergyKwh::selectRaw('DATE(created_at) as date, MAX(created_at) as latest_updated')
            ->where('id_kwh', '=', $id)
            ->groupBy('id_kwh', 'date')
            ->oldest('latest_updated')
            ->get();

        foreach ($data as $item) {
            $energy = EnergyKwh::select('total_energy', 'created_at')
                ->where('id_kwh', $id)
                ->whereDate('created_at', $item->date)
                ->latest('created_at')
                ->first();

            $item->energy_meter = $energy->total_energy;
            $item->timestamp = strtotime($energy->created_at) * 1000;
        }


        $length = count($data);

        for ($i = 1; $i < $length; $i++) {
            $data[$i]->today_energy = $data[$i]->energy_meter - $data[$i - 1]->energy_meter;
        }

        // Menghilangkan data paling awal karena digunakan untuk pengurangan
        $data->shift();

        return $data;
    }

    public function getDailyEnergyStat($id)
    {
        if ($id > 4) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        $data = EnergyKwh::selectRaw('DATE(created_at) as date, MAX(created_at) as latest_updated')
            ->where('id_kwh', '=', $id)
            ->groupBy('id_kwh', 'date')
            ->latest('latest_updated')
            ->limit(101)->get();

        foreach ($data as $item) {
            $energy = EnergyKwh::select('total_energy')
                ->where('id_kwh', $id)
                ->whereDate('created_at', $item->date)
                ->latest('created_at') // Pilih baris terbaru
                ->first();

            $item->energy_meter = $energy->total_energy;
        }

        $length = count($data);

        for ($i = 0; $i < $length - 1; $i++) {
            $data[$i]->energy = ($data[$i]->energy_meter - $data[$i + 1]->energy_meter) / 1000;
        }

        $data->makeHidden('energy_meter');
        $data->makeHidden('latest_updated');
        // Remove the last item from the collection since there is no next day for the last day
        $data->pop();

        return $data;
    }

    public function getMonthlyEnergy($id)
    {
        // Versi Mario
        $data = EnergyKwh::selectRaw('MONTH(created_at) as month, YEAR(created_at) as tahun, MAX(created_at) as latest_updated, MAX(total_energy) as total_energy')
            ->where('id_kwh', '=', $id)
            ->groupBy('month', 'tahun')
            ->oldest('latest_updated')
            ->get();
        $price = EnergyCost::latest()->first()->harga;

        $length = count($data);
        // $data[$length-1]->monthly_kwh = ($data[$length-1]->energy_meter - 6950)/1000; // pertama kali pasang di 30 des dengan kwh meter start dari 6950

        for ($i = 1; $i < $length; $i++) {
            $data[$i]->monthly_kwh = ($data[$i]->total_energy - $data[$i - 1]->total_energy) / 1000; // energy perbulan dalam kWh
            $data[$i]->bill = intval($data[$i]->monthly_kwh * $price); // biaya listrik perbulan
            $angka_ike = $data[$i]->monthly_kwh / 33.1;
            $data[$i]->angka_ike = round($angka_ike, 2);
            switch ($angka_ike) {
                case $angka_ike <= 7.92:
                    $ike = 'Sangat Efisien';
                    $color = '#00ff00';
                    break;
                case $angka_ike > 7.92 && $angka_ike <= 12.08:
                    $ike = 'Efisien';
                    $color = '#009900';
                    break;
                case $angka_ike > 12.08 && $angka_ike <= 14.58:
                    $ike = 'Cukup Efisien';
                    $color = '#ffff00';
                    break;
                case $angka_ike > 14.58 && $angka_ike <= 19.17:
                    $ike = 'Agak Boros';
                    $color = '#ff9900';
                    break;
                case $angka_ike > 19.17 && $angka_ike <= 23.75:
                    $ike = 'Boros';
                    $color = '#ff3300';
                    break;
                default:
                    $ike = 'Sangat Boros';
                    $color = '#800000';
                    break;
            }
            $data[$i]->ike = $ike;
            $data[$i]->color = $color;
            $data[$i]->bulan = Carbon::create(null, $data[$i]->month)->monthName;
        }

        // Remove the last item from the collection since there is no next day for the last day
        $data->shift();

        $data->makeHidden(['energy_meter']);

        return $data;
    }

    public function getMonthlyEnergyStat($id)
    {
        $data = EnergyKwh::selectRaw('MONTH(created_at) as month, YEAR(created_at) as tahun, MAX(created_at) as latest_updated, MAX(total_energy) as total_energy')
            ->where('id_kwh', '=', $id)
            ->groupBy('month', 'tahun')
            ->latest('latest_updated')
            ->get();

        $price = EnergyCost::latest()->first()->pokok;

        $length = count($data);

        for ($i = 0; $i < $length - 1; $i++) {
            $data[$i]->monthly_kwh = ($data[$i]->total_energy - $data[$i + 1]->total_energy) / 1000; // energy perbulan dalam kWh
            $angka_ike = $data[$i]->monthly_kwh / 33.1;
            $data[$i]->angka_ike = round($angka_ike, 2);
            switch ($angka_ike) {
                case $angka_ike <= 7.92:
                    $ike = 'Sangat Efisien';
                    $color = '#00ff00';
                    break;
                case $angka_ike > 7.92 && $angka_ike <= 12.08:
                    $ike = 'Efisien';
                    $color = '#009900';
                    break;
                case $angka_ike > 12.08 && $angka_ike <= 14.58:
                    $ike = 'Cukup Efisien';
                    $color = '#ffff00';
                    break;
                case $angka_ike > 14.58 && $angka_ike <= 19.17:
                    $ike = 'Agak Boros';
                    $color = '#ff9900';
                    break;
                case $angka_ike > 19.17 && $angka_ike <= 23.75:
                    $ike = 'Boros';
                    $color = '#ff3300';
                    break;
                default:
                    $ike = 'Sangat Boros';
                    $color = '#800000';
                    break;
            }
            $data[$i]->ike = $ike;
            $data[$i]->color = $color;
        }

        // Remove the last item from the collection since there is no next day for the last day
        $data->pop();

        $data->makeHidden(['total_energy', 'latest_updated']);

        return $data;
    }

    public function getAnnualEnergy($id)
    {
        $data = EnergyKwh::selectRaw('YEAR(created_at) as tahun, MAX(created_at) as latest_updated')
            ->where('id_kwh', '=', $id)
            ->groupBy('id_kwh', 'tahun')
            ->oldest('latest_updated')
            ->get();


        foreach ($data as $item) {
            $energy = EnergyKwh::select('total_energy', 'created_at')
                ->where('id_kwh', $id)
                ->where('created_at', $item->latest_updated)
                ->latest('created_at')
                ->first();

            $item->energy_meter = $energy->total_energy / 1000;
            $item->timestamp = strtotime($energy->created_at) * 1000;
        }

        $length = count($data);
        for ($i = 1; $i < $length; $i++) {
            $data[$i]->annual_kwh = $data[$i]->energy_meter - $data[$i - 1]->energy_meter;
            $angka_ike = $data[$i]->annual_kwh / 33.1;
            $data[$i]->angka_ike = $angka_ike;
            switch ($angka_ike) {
                case $angka_ike <= 95:
                    $ike = 'Sangat Efisien';
                    $color = '#00ff00';
                    break;
                case $angka_ike > 95 && $angka_ike <= 145:
                    $ike = 'Efisien';
                    $color = '#009900';
                    break;
                case $angka_ike > 145 && $angka_ike <= 175:
                    $ike = 'Cukup Efisien';
                    $color = '#ffff00';
                    break;
                case $angka_ike > 175 && $angka_ike <= 285:
                    $ike = 'Agak Boros';
                    $color = '#ff9900';
                    break;
                case $angka_ike > 285 && $angka_ike <= 450:
                    $ike = 'Boros';
                    $color = '#ff3300';
                    break;
                default:
                    $ike = 'Sangat Boros';
                    $color = '#800000';
                    break;
            }
            $data[$i]->ike = $ike;
            $data[$i]->color = $color;
        }
        $data->shift();

        return $data;
    }

    public function export_excel()
    {
        return Excel::download(new EnergyExport, 'energy.xlsx');
    }
    public function export_excel_csv()
    {
        return Excel::download(new EnergyExport, 'energy.csv');
    }
}
