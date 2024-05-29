<?php

namespace App\Exports;

use App\Models\Energy;
use App\Models\Driver;
use Maatwebsite\Excel\Concerns\WithHeadings;    
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class EnergyRawExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Energy::all();
    }

    public function headings() :array
    {
        return [ "id",'id_kwh','frekuensi','arus','tegangan','active_power','reactive_power','apparent_power',"created_at",'updated_at'];
    }
}
