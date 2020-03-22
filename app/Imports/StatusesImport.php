<?php

namespace App\Imports;

use App\Brand;
use App\Status;
use Maatwebsite\Excel\Concerns\ToModel;

class StatusesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Status([
            'status_code'     => $row[0],
            'status_name'    => $row[1],
            'status_status'    => $row[2],
            'user_id'    => '1',
        ]);
    }
}
