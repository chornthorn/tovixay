<?php

namespace App\Exports;

use App\AssetModel;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetModelsExport implements FromCollection,WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $excel = DB::table('asset_models')
            ->join('users', 'users.id', '=', 'asset_models.user_id')
            ->select('asset_models.model_code', 'asset_models.model_name', 'users.name', 'asset_models.created_at', 'asset_models.updated_at')->get();

        return $excel;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Model Code',
            'Model Name',
            'By User',
            'Created at',
            'Updated at'
        ];
    }
}
