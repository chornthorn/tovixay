<?php

namespace App\Exports;

use App\Status;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StatusesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $excel = DB::table('statuses')
            ->join('users', 'users.id', '=', 'statuses.user_id')
            ->select('statuses.status_code', 'statuses.status_name', 'users.name', 'statuses.created_at', 'statuses.updated_at')->get();

        return $excel;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Status Code',
            'Status Name',
            'By User',
            'Created at',
            'Updated at'
        ];
    }
}
