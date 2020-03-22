<?php

namespace App\Imports;

use App\AssetModel;
use Maatwebsite\Excel\Concerns\ToModel;

class ModelsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new AssetModel([
            'model_code'     => $row[0],
            'model_name'    => $row[1],
            'model_status'    => $row[2],
            'user_id'    => '1',
        ]);
    }
}
