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

        // Energy
        $energy1 = Energy::where('id_kwh', 1)->latest()->first();
        $energy2 = Energy::where('id_kwh', 2)->latest()->first();
        $energy3 = Energy::where('id_kwh', 3)->latest()->first();
        $energy4 = Energy::where('id_kwh', 4)->latest()->first();

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

            // Energy
            $energy1 = Energy::where('id_kwh', 1)->latest()->first();
            $energy2 = Energy::where('id_kwh', 2)->latest()->first();
            $energy3 = Energy::where('id_kwh', 3)->latest()->first();
            $energy4 = Energy::where('id_kwh', 4)->latest()->first();

            $avgVolt = ($energy1->v_A + $energy2->v_A + $energy3->v_A + $energy4->v_A) / 4;
            $avgCurrent = ($energy1->i_A + $energy2->i_A + $energy3->i_A + $energy4->i_A) / 4;
            $avgFreq = ($energy1->frekuensi + $energy2->frekuensi + $energy3->frekuensi + $energy4->frekuensi) / 4;
            $avgP = ($energy1->p_A + $energy2->p_A + $energy3->p_A + $energy4->p_A) / 4;
            $avgQ = ($energy1->reactive_power + $energy2->reactive_power + $energy3->reactive_power + $energy4->reactive_power) / 4;
            $avgS = (($energy1->pf_A + $energy2->pf_A + $energy3->pf_A + $energy4->pf_A) / 4) / 10;

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
