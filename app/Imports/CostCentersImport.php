<?php

namespace App\Imports;

use App\CostCenter;
use Maatwebsite\Excel\Concerns\ToModel;

class CostCentersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CostCenter([
            'costcenter_code'     => $row[0],
            'costcenter_name'    => $row[1],
            'costcenter_status'    => $row[2],
            'user_id'    => '1',
        ]);
    }
}
