<?php

namespace App\Exports;

use App\CostCenter;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class CostCentersExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $excel = DB::table('cost_centers')
            ->join('users', 'users.id', '=', 'cost_centers.user_id')
            ->select('cost_centers.costcenter_code', 'cost_centers.costcenter_name', 'users.name', 'cost_centers.created_at', 'cost_centers.updated_at')->get();

        return $excel;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Cost Center Code',
            'Cost Center Name',
            'By User',
            'Created at',
            'Updated at'
        ];
    }
}
