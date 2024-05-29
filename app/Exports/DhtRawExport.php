<?php

namespace App\Exports;

use App\Models\DhtSensor;
use App\Models\Driver;
use Maatwebsite\Excel\Concerns\WithHeadings;    
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromCollection;

class DhtRawExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return DhtSensor::all();
    }
    public function headings() :array
    {
        return [ "id",'temperature', 'humidity',"created_at",'updated_at'];
    }
}
