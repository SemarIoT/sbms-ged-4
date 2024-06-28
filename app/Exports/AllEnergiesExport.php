<?php

namespace App\Exports;

use App\Models\Energy;
use App\Models\Driver;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class AllEnergiesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return ['id', 'id_kwh', 'i_A', 'i_B', 'i_C', 'v_A', 'v_B', 'v_C', 'p_A', 'p_B', 'p_C', 'pf_A', 'pf_B', 'pf_C', 'frekuensi', 'reactive_power', 'timestamp'];
    }

    public function collection()
    {
        $data = Energy::all();
        $formattedData = $data->map(function ($item) {
            $item->created_at_formatted = $item->created_at->format('d M Y H:i:s');
            return $item;
        });

        // Hide the created_at and updated_at fields
        $formattedData->makeHidden(['created_at', 'updated_at']);
        return $formattedData;
    }
}
