<?php

namespace App\Imports;

use App\Location;
use Maatwebsite\Excel\Concerns\ToModel;

class LocationsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Location([
            'location_code'     => $row[0],
            'location_name'    => $row[1],
            'location_status'    => $row[2],
            'user_id'    => '1',
        ]);
    }
}
