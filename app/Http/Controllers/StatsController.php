<?php

namespace App\Http\Controllers;

use App\Models\Energy;
use App\Models\EnergyKwh;
use App\Models\EnergyCost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StatsController extends Controller
{
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

    public function getArusStatA($id)
    {
        $results = Energy::where('id_kwh', $id)->select('i_A', 'created_at')->latest()->limit(500)->get();

        return response()->json($results);
    }
    public function getArusStatB($id)
    {
        $results = Energy::where('id_kwh', $id)->select('i_B', 'created_at')->latest()->limit(500)->get();

        return response()->json($results);
    }
    public function getArusStatC($id)
    {
        $results = Energy::where('id_kwh', $id)->select('i_C', 'created_at')->latest()->limit(500)->get();

        return response()->json($results);
    }

    public function getActivePowerStatA($id)
    {
        $results = Energy::where('id_kwh', $id)->select('p_A', 'created_at')->latest()->limit(500)->get();

        return response()->json($results);
    }
    public function getActivePowerStatB($id)
    {
        $results = Energy::where('id_kwh', $id)->select('p_B', 'created_at')->latest()->limit(500)->get();

        return response()->json($results);
    }
    public function getActivePowerStatC($id)
    {
        $results = Energy::where('id_kwh', $id)->select('p_C', 'created_at')->latest()->limit(500)->get();

        return response()->json($results);
    }
}
