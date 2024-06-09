<?php

namespace App\Exports;

use App\Models\Driver;
use App\Models\EnergyKwh;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class KwhExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return ['id', 'id_kwh', 'Total Energi (Wh)', 'timestamp'];
    }

    public function collection()
    {
        $data = EnergyKwh::all();
        $formattedData = $data->map(function ($item) {
            $item->created_at_formatted = $item->created_at->format('d M Y H:i:s');
            return $item;
        });

        $formattedData->makeHidden(['created_at', 'updated_at']);

        return $formattedData;
    }
}
