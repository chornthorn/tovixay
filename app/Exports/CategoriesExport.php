<?php

namespace App\Exports;

use App\Category;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoriesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $category = DB::table('categories')
            ->join('users', 'users.id', '=', 'categories.user_id')
            ->select('categories.id', 'categories.category_name', 'users.name', 'categories.created_at', 'categories.updated_at')->get();

        return $category;
    }

    /**
     * @inheritDoc
     */
    public function headings(): array
    {
        return [
            'Category Code',
            'Category Name',
            'By User',
            'Created at',
            'Updated at'
        ];
    }
}
