<?php

namespace App\Exports;

use App\Role;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RolesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $excel = DB::table('permission_role AS pr')
            ->join('roles AS r', 'r.id', '=', 'pr.role_id')
            ->join('permissions AS p', 'p.id', '=', 'pr.permission_id')
            ->select('r.name AS role_name','p.name AS permission_name','p.for')->get();

        return $excel;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Role Name',
            'Permission Name',
            'For',
        ];
    }
}
