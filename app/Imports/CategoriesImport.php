<?php

namespace App\Imports;

use App\Category;
use Maatwebsite\Excel\Concerns\ToModel;

class CategoriesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Category([
            'id'     => $row[0],
            'category_name'    => $row[1],
            'category_status'    => $row[2],
            'user_id'    => '1',
        ]);
    }
}
