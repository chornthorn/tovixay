<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ComputersExport implements FromCollection , WithHeadings, ShouldAutoSize
{

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $computer = DB::table('computers')
            ->join('assets','assets.id','=','computers.asset_id')
            ->join('brands','brands.id','=','assets.brand_id')
            ->join('asset_models','asset_models.id','=','assets.model_id')
            ->join('categories','categories.id','=','assets.category_id')
            ->join('cost_centers','cost_centers.id','=','assets.costcenter_id')
            ->join('statuses','statuses.id','=','assets.status_id')
            ->join('locations','locations.id','=','assets.location_id')
            ->join('users','users.id','=','computers.user_id')
            ->select('assets.asset_code AS assetCode',
                'assets.asset_it_code AS assetItCode',
                'assets.asset_name AS assetName',
                'brands.brand_name AS brandName',
                'asset_models.model_name AS modelName',
                'categories.category_name AS categoryName',
                'statuses.status_name AS statusName',
                'cost_centers.costcenter_name AS costcenterName',
                'locations.location_name AS locationName',
                'computers.monitor_item',
                'computers.mainboard_item',
                'computers.cpu_item',
                'computers.harddisk_item',
                'computers.ram_item',
                'computers.powersupply_item',
                'computers.keyboard_item',
                'computers.mouse_item',
                'computers.cdrom_item',
                'users.name AS userName',
                'computers.created_at AS create_computer',
                'computers.updated_at AS update_computer'
            )
            ->get();

        return $computer;
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
            'Monitor',
            'Mainboard',
            'CPU',
            'Hard Disk',
            'RAM',
            'Power Supply',
            'Keyboard',
            'Mouse',
            'CD Rom',
            'By User',
            'Created at',
            'Updated at'
        ];
    }
}
