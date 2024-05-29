<?php

namespace App\Exports;

use App\Models\DhtSensor;
use App\Models\Driver;
use Maatwebsite\Excel\Concerns\WithHeadings;    
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;


class DhtExportHumid implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings() :array
    {
        return ["#", "humidity","created_at"];
    }
    public function collection()
    {
        return DhtSensor::select('id','humidity','created_at')->get();
    }
}
