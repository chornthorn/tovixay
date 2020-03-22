<?php

namespace App\Imports;

use App\Brand;
use Maatwebsite\Excel\Concerns\ToModel;

class BrandsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Brand([
            'brand_code'     => $row[0],
            'brand_name'    => $row[1],
            'brand_status'    => $row[2],
            'user_id'    => '1',
        ]);
    }
}
