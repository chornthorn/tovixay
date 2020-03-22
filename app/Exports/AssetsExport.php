<?php

namespace App\Exports;

use App\Asset;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetsExport implements FromCollection , WithHeadings, ShouldAutoSize
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $asset = DB::table('assets')
            ->join('brands', 'brands.id', '=', 'assets.brand_id')
            ->join('asset_models', 'asset_models.id', '=', 'assets.model_id')
            ->join('categories', 'categories.id', '=', 'assets.category_id')
            ->join('statuses', 'statuses.id', '=', 'assets.status_id')
            ->join('cost_centers', 'cost_centers.id', '=', 'assets.costcenter_id')
            ->join('locations', 'locations.id', '=', 'assets.location_id')
            ->join('users', 'users.id', '=', 'assets.user_id')
            ->select('assets.asset_code','assets.asset_it_code','assets.asset_name', 'brands.brand_name', 'asset_models.model_name',
                'categories.category_name', 'statuses.status_name', 'cost_centers.costcenter_name',
                'locations.location_name', 'users.name','assets.created_at','assets.updated_at')
            ->get();

        return $asset;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Asset Code',
            'Asset IT Code',
            'Asset Name',
            'Brand',
            'Model',
            'Category',
            'Status',
            'Cost Center',
            'Location',
            'By User',
            'Created at',
            'Updated at'
        ];
    }
}
