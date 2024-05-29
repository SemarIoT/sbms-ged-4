<?php

namespace App\Exports;

use DB;
use App\Models\Energy;
use App\Models\Driver;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class EnergyExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return ["Tanggal", "AC 1", "AC 2", "Outlet", "Lampu", "Total (kWh)"];
    }
    public function collection()
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
        return collect($results);
    }
}
