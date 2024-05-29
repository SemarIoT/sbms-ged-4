<?php

namespace App\Http\Controllers;

use App\Models\Light;
use App\Models\Energy;
use App\Models\IkeDummy;
use App\Models\DhtSensor;
use App\Models\EnergyKwh;
use App\Models\EnergyCost;
use App\Models\EnergyPanel;
use App\Models\LightMaster;
use Illuminate\Http\Request;
use App\Models\EnergiesForDev;
use Illuminate\Support\Carbon;
use App\Models\EnergyPanelMaster;
use App\Models\EnergyOutletMaster;
use Illuminate\Support\Facades\DB;

class NodeDataController extends Controller
{
    // untuk mencoba function-function
    public function cekApi()
    {
        $results = DB::select("
        SELECT
            DATE(energies.created_at) AS date,
            ROUND(SUM(CASE WHEN id_kwh = 1 THEN active_power * energy_costs.delay / 3600 ELSE 0 END), 2) AS energy_1,
            ROUND(SUM(CASE WHEN id_kwh = 2 THEN active_power * energy_costs.delay / 3600 ELSE 0 END), 2) AS energy_2,
            ROUND(SUM(CASE WHEN id_kwh = 3 THEN active_power * energy_costs.delay / 3600 ELSE 0 END), 2) AS energy_3,
            ROUND(SUM(CASE WHEN id_kwh = 4 THEN active_power * energy_costs.delay / 3600 ELSE 0 END), 2) AS energy_4,
            ROUND(SUM(active_power* energy_costs.delay / 3600),2) AS daily_energy
        FROM
            energies
        JOIN energy_costs 
        GROUP BY
            date
        ORDER BY
            date
    ");
        return $results;
    }

    /* 
        Membaca data kwh meter urut dari paling baru
        dibatasi 300 agar tidak berat querynya
    */
    public function getAllEnergyMonitor()
    {
        $data = Energy::latest()->take(300)->get();
        $formattedData = $data->map(function ($item) {
            $item->created_at_formatted = $item->created_at->format('d M Y H:i:s');
            return $item;
        });

        // Hide the created_at and updated_at fields
        $formattedData->makeHidden(['created_at', 'updated_at']);
        return response($formattedData, 200);
    }

    /* 
        Menyimpan data dari Teensy
    */
    public function addEnergyMonitor(Request $request)
    {
        $data = new Energy;
        $data->id_kwh = $request->id_kwh;
        $data->frekuensi = $request->f;
        $data->arus = $request->i;
        $data->tegangan = $request->v;
        $data->active_power = $request->p;
        $data->reactive_power = $request->q;
        $data->apparent_power = $request->s;
        if ($request->energy) {
            $data->energy = $request->energy;
        }

        $data->save();

        return response()->json([
            "message" => "data record added"
        ], 201);
    }

    /* 
        Membaca state dari AC 1, AC 2 dan Outlet untuk kontrol 
    */
    public function getEnergyState()
    {
        $data = EnergyPanel::select('nama', 'status')->where('nama', '=', 'AC 1')->first()->status;
        $data2 = EnergyPanel::select('nama', 'status')->where('nama', '=', 'AC 2')->first()->status;
        $data3 = EnergyPanel::select('nama', 'status')->where('nama', '=', 'Outlet')->first()->status;
        $data4 = Light::find(1)->status;
        $data5 = EnergyPanelMaster::select('nama', 'status')->where('nama', '=', 'Master')->first()->status;

        return response()->json(['AC 1' => $data, 'AC 2' => $data2, 'Outlet' => $data3, 'Lampu' => $data4, 'Master' => $data5]);
    }

    /* 
        Return 1000 data terakhir dari 'total
    */
    public function getTotalEnergy()
    {
        $data = EnergyKwh::latest()->get();
        $formattedData = $data->map(function ($item) {
            $item->created_at_formatted = $item->created_at->format('d M Y H:i:s');
            return $item;
        });

        $formattedData->makeHidden(['created_at', 'updated_at']);

        return $formattedData;
    }

    public function addTotalEnergy(Request $request)
    {
        // Validasi agar data tersimpan setiap 5 menit sekali saja
        // Jaga-jaga kalau end-node error dan ngirim beberapa kali

        $latestData = EnergyKwh::where('id_kwh', $request->id_kwh)
            ->latest('created_at')
            ->first();
        if ($latestData) {
            // $fiveMinutesAgo = Carbon::now()->subMinutes(4);
            $fiveMinutesAgo = Carbon::now()->subMinutes(0);
            if ($latestData->created_at < $fiveMinutesAgo) {
                // Save the new data
                $data = new EnergyKwh;
                $data->id_kwh = $request->id_kwh;
                $data->total_energy = $request->total_energy;
                $data->save();

                return response()->json([
                    "message" => "Data record added"
                ], 201);
            } else {
                return response()->json([
                    "message" => "Sorry, belum 5 menit"
                ], 400);
            }
        } else {
            // Save the new data if no previous data exists
            $data = new EnergyKwh;
            $data->id_kwh = $request->id_kwh;
            $data->total_energy = $request->total_energy;
            $data->save();

            return response()->json([
                "message" => "Data record added"
            ], 201);
        }
    }

    public function addDebugEnergy(Request $request)
    {
        $data = new EnergiesForDev;
        $data->id_kwh = $request->id_kwh;
        $data->frekuensi = $request->f;
        $data->arus = $request->i;
        $data->tegangan = $request->v;
        $data->active_power = $request->p;
        $data->reactive_power = $request->q;
        $data->apparent_power = $request->s;
        $data->total_energy = $request->total_energy;
        $saved = $data->save();

        if ($saved) {
            return response()->json([
                "message" => "data record added"
            ], 201);
        } else {
            return response()->json([
                "message" => "Failed to add data record"
            ], 500); // You can use a different HTTP status code based on your application's needs
        }
    }

    public function getDailyEnergy($id)
    {
        $data = EnergyKwh::selectRaw('DATE(created_at) as date, MAX(created_at) as latest_updated, MAX(total_energy) as energy_meter')
            ->where('id_kwh', '=', $id)
            ->groupBy('id_kwh', 'date')
            ->latest('latest_updated')
            ->get();

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

    public function getMonthlyEnergy($id)
    {
        // Versi Mario
        $data = EnergyKwh::selectRaw('MONTH(created_at) as month, YEAR(created_at) as tahun, MAX(created_at) as latest_updated, MAX(total_energy) as energy_meter')
            ->where('id_kwh', '=', $id)
            ->groupBy('month', 'tahun')
            ->latest('latest_updated')
            ->get();

        $price = EnergyCost::latest()->first()->pokok;

        $length = count($data);

        for ($i = 0; $i < $length - 1; $i++) {
            $data[$i]->monthly_kwh = ($data[$i]->energy_meter - $data[$i + 1]->energy_meter) / 1000; // energy perbulan dalam kWh
            $data[$i]->bill = intval($data[$i]->monthly_kwh * $price); // biaya listrik perbulan
            $angka_ike = $data[$i]->monthly_kwh / 33.1; // | 33,1 luas ruangan IoT
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

        $data->makeHidden(['energy_meter']);

        return $data;
    }

    public function getIkeDummy()
    {
        $data = IkeDummy::selectRaw('MONTH(created_at) as month, YEAR(created_at) as tahun, MAX(created_at) as latest_updated, MAX(total_energy) as monthly_kwh')
            ->groupBy('month', 'tahun')
            ->latest('latest_updated')
            ->get();

        // return $data;
        $length = count($data);

        for ($i = 0; $i < $length; $i++) {
            $angka_ike = number_format($data[$i]->monthly_kwh / 33.1, 2);
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
        return $data;
    }

    public function getIkeDummyAnnual()
    {
        $data = IkeDummy::selectRaw('YEAR(created_at) as tahun, MAX(created_at) as latest_updated, SUM(total_energy) as annual_kwh')
            ->groupBy('tahun')
            ->latest('latest_updated')
            ->get();

        // return $data;
        $length = count($data);

        for ($i = 0; $i < $length; $i++) {
            $angka_ike = number_format($data[$i]->annual_kwh / 33.1, 2);
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
        return $data;
    }

    public function energyStatistik()
    {
        $energiwh = DB::select('SELECT date(energies.created_at)as date,SUM(energies.active_power*(energy_costs.delay/3600)) AS sale FROM energies JOIN energy_costs WHERE id_kwh = 1 GROUP BY date(energies.created_at) DESC');
        return response()->json($energiwh);
    }

    public function dailyEnergy($id)
    {
        if ($id > 4) {
            return response("Not Found", 404);
        }
        $energiwh = DB::select("SELECT date(energies.created_at) as date, SUM(energies.active_power * (energy_costs.delay / 3600)) AS energy FROM energies JOIN energy_costs WHERE id_kwh = $id GROUP BY date(energies.created_at) DESC");
        return response()->json($energiwh);
    }

    public function suhulogger()
    {
        $suhulogger = DhtSensor::select(DhtSensor::raw('created_at as date'), DhtSensor::raw('AVG(temperature) as sale'))->groupBy(DhtSensor::raw('created_at'))->get();

        return response()->json($suhulogger);
    }

    public function humidlogger()
    {
        $humidlogger = DhtSensor::select(DhtSensor::raw('created_at as date'), DhtSensor::raw('AVG(humidity) as sale'))->groupBy(DhtSensor::raw('created_at'))->get();

        return response()->json($humidlogger);
    }

    public function luxlogger()
    {
        $humidlogger = DhtSensor::select(DhtSensor::raw('created_at as date'), DhtSensor::raw('AVG(lux) as sale'))->groupBy(DhtSensor::raw('created_at'))->get();

        return response()->json($humidlogger);
    }

    /* 
        Membaca status lampu
    */
    public function getLightState($id)
    {
        if (Light::where('id', $id)->exists()) {
            $data = Light::where('id', $id)->first(); //->toJson(JSON_PRETTY_PRINT);
            return $data;
        } else {
            return response()->json([
                "message" => "Data not found"
            ], 404);
        }
    }

    /* 
        Membaca 300 nilai DHT terbaru
    */
    public function getDht()
    {
        $data = DhtSensor::latest()->take(300)->get(); // Limit 100 biar tidak berat loadnya
        return $data;
    }

    /* 
        Menyimpan nilai dari sensor DHT ke DB
    */
    public function postDht(Request $request)
    {
        $data = new DhtSensor;
        $data->temperature = $request->temperature;
        $data->humidity = $request->humidity;
        $data->lux = $request->lux;
        $data->save();
        return 201;
    }
}
