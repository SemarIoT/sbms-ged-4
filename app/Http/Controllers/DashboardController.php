<?php

namespace App\Http\Controllers;

use App\Models\Energy;
use App\Models\EnergyCost;
use App\Models\EnergyPanel;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // DateTime
        $todayDate = Carbon::today()->toDateString(); // return Y-m-d string
        $yesterdayDate = Carbon::now()->subDays(1)->toDateString();
        $thisMonth = Carbon::now()->month; // return int
        $lastMonth = Carbon::now()->month - 1;
        $thisYear = Carbon::now()->year;
        // Energy
        $energy1 = Energy::where('id_kwh', 1)->latest()->first();
        $energy2 = Energy::where('id_kwh', 2)->latest()->first();
        $energy3 = Energy::where('id_kwh', 3)->latest()->first();
        $energy4 = Energy::where('id_kwh', 4)->latest()->first();
        $energyTillNow = $energy1->energy + $energy2->energy + $energy3->energy + $energy4->energy;
        // EnergyToday
        $energyYesterday = 0;
        for ($i = 1; $i <= 4; $i++) {
            try {
                $eachYesterday = Energy::where('id_kwh', $i)->whereDate('created_at', $yesterdayDate)->latest()->first()->energy;
            } catch (\Throwable $th) {
                $eachYesterday = Energy::where('id_kwh', $i)->latest()->first()->energy;
            }

            $energyYesterday += $eachYesterday;
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
        $energy_cost = EnergyCost::latest()->pluck('harga')->first();

        // Device Status
        $panels = EnergyPanel::get();


        return view('dashboard', compact(
            'energy_today',
            'energy1',
            'energy2',
            'energy3',
            'energy4',
            'energy_month',
            'energyLastMonth',
            'energy_cost',
            'panels',
        ));
    }
}
