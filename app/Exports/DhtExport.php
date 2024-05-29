<?php

namespace App\Exports;

use App\Models\DhtSensor;
use App\Models\Driver;
use Maatwebsite\Excel\Concerns\WithHeadings;    
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class DhtExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings() :array
    {
        return ["#", "temperature","created_at"];
    }
    public function collection()
    {
        return DhtSensor::select('id','temperature','created_at')->get();
    }
    
}
