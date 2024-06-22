<?php

namespace App\Http\Controllers;

use App\Models\Energy;
use App\Models\EnergyKwh;
use App\Models\EnergyCost;
use App\Models\EnergyPanel;
use Illuminate\Support\Carbon;

class PagesController extends Controller
{
    public function noAuth()
    {
        if (auth()->check()) {
            return $this->wasLogin();
        }

        // DateTime
        $lastMonth = Carbon::now()->month - 1;
        $thisYear = Carbon::now()->year;

        // Energy
        $energy1 = Energy::where('id_kwh', 1)->latest()->first();
        $energy2 = Energy::where('id_kwh', 2)->latest()->first();
        $energy3 = Energy::where('id_kwh', 3)->latest()->first();
        $energy4 = Energy::where('id_kwh', 4)->latest()->first();
        $energyTillNow = $energy1->energy + $energy2->energy + $energy3->energy + $energy4->energy;

        // EnergyToday
        $econ = new EnergyController();
        $eachTodayEnergy = [];
        for ($i = 1; $i <= 4; $i++) {
            $eachTodayEnergy[$i] = $econ->getTodayEnergy($i)->first()->today_energy;
        }
        $energy_today = array_sum($eachTodayEnergy) / 1000;

        // Energy Last Month
        $energyLastMonth = 0;
        for ($i = 1; $i <= 4; $i++) {
            try {
                $eachLastMonth = EnergyKwh::where('id_kwh', $i)->whereMonth('created_at', $lastMonth)->whereYear('created_at', $thisYear)->latest()->first()->total_energy / 1000;
            } catch (\Exception $e) {
                // Jika data bulan yang lalu belum ada, maka dianggap 0
                $eachLastMonth = 0;
            }
            $energyLastMonth += $eachLastMonth;
        }
        // Energy This Month
        $eachMonthEnergy = [];
        for ($i = 1; $i <= 4; $i++) {
            $eachMonthEnergy[$i] = $econ->getThisMonthEnergy($i)->first()->monthly_kwh;
        }
        $energy_month = array_sum($eachMonthEnergy);
        $energy_cost = EnergyCost::latest()->pluck('harga')->first();

        // Device Status
        $panels = EnergyPanel::get();


        return view('dashboards', compact(
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

    public function wasLogin()
    {
        if (!auth()->check()) {
            return redirect('/login');
        } else {
            // DateTime
            $lastMonth = Carbon::now()->month - 1;
            $thisYear = Carbon::now()->year;

            // Energy
            $energy1 = Energy::where('id_kwh', 1)->latest()->first();
            $energy2 = Energy::where('id_kwh', 2)->latest()->first();
            $energy3 = Energy::where('id_kwh', 3)->latest()->first();
            $energy4 = Energy::where('id_kwh', 4)->latest()->first();
            $energyTillNow = $energy1->energy + $energy2->energy + $energy3->energy + $energy4->energy;

            // EnergyToday
            $econ = new EnergyController();
            $eachTodayEnergy = [];
            for ($i = 1; $i <= 4; $i++) {
                $eachTodayEnergy[$i] = $econ->getTodayEnergy($i)->first()->today_energy;
            }
            $energy_today = array_sum($eachTodayEnergy) / 1000;

            // Energy Last Month
            $energyLastMonth = 0;
            for ($i = 1; $i <= 4; $i++) {
                try {
                    $eachLastMonth = EnergyKwh::where('id_kwh', $i)->whereMonth('created_at', $lastMonth)->whereYear('created_at', $thisYear)->latest()->first()->total_energy / 1000;
                } catch (\Exception $e) {
                    // Jika data bulan yang lalu belum ada, maka dianggap 0
                    $eachLastMonth = 0;
                }
                $energyLastMonth += $eachLastMonth;
            }
            // Energy This Month
            $eachMonthEnergy = [];
            for ($i = 1; $i <= 4; $i++) {
                $eachMonthEnergy[$i] = $econ->getThisMonthEnergy($i)->first()->monthly_kwh;
            }
            $energy_month = array_sum($eachMonthEnergy);
            $energy_cost = EnergyCost::latest()->pluck('harga')->first();

            $avgVolt = ($energy1->tegangan + $energy2->tegangan + $energy3->tegangan + $energy4->tegangan) / 4;
            $avgCurrent = ($energy1->arus + $energy2->arus + $energy3->arus + $energy4->arus) / 4;
            $avgFreq = ($energy1->frekuensi + $energy2->frekuensi + $energy3->frekuensi + $energy4->frekuensi) / 4;
            $avgP = ($energy1->active_power + $energy2->active_power + $energy3->active_power + $energy4->active_power) / 4;
            $avgQ = ($energy1->reactive_power + $energy2->reactive_power + $energy3->reactive_power + $energy4->reactive_power) / 4;
            $avgS = ($energy1->power_factor + $energy2->power_factor + $energy3->power_factor + $energy4->power_factor) / 4;

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
                'avgVolt',
                'avgCurrent',
                'avgFreq',
                'avgP',
                'avgQ',
                'avgS'
            ));
        }
    }
}
