<?php

namespace App\Exports;

use App\Models\Structure;
use Maatwebsite\Excel\Concerns\FromCollection;

class StructuresExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Structure::all();
    }
}
