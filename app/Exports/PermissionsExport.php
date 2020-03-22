<?php

namespace App\Exports;

use App\Permission;
use Maatwebsite\Excel\Concerns\FromCollection;

class PermissionsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Permission::all();
    }
}
