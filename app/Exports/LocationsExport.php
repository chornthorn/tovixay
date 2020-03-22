<?php

namespace App\Exports;

use App\Location;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class LocationsExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $excel = DB::table('locations')
            ->join('users', 'users.id', '=', 'locations.user_id')
            ->select('locations.location_code', 'locations.location_name', 'users.name', 'locations.created_at', 'locations.updated_at')->get();

        return $excel;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Location Code',
            'Location Name',
            'By User',
            'Created at',
            'Updated at'
        ];
    }
}
