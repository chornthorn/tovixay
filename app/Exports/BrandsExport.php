<?php

namespace App\Exports;

use App\Brand;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BrandsExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $excel = DB::table('brands')
            ->join('users', 'users.id', '=', 'brands.user_id')
            ->select('brands.brand_code', 'brands.brand_name', 'users.name', 'brands.created_at', 'brands.updated_at')->get();

        return $excel;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Brand Code',
            'Brand Name',
            'By User',
            'Created at',
            'Updated at'
        ];
    }
}
