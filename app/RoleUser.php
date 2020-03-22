<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class RoleUser extends Model
{
    protected $table = 'role_user';
    protected $primaryKey = ['user_id', 'role_id'];

    public static function findByUserId($id) {
        $table = DB::table('role_user');
        $result = $table->where('user_id', $id)->get();
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }

    /**
     * @param int $id
     * @param $pagingQuery
     * @return array
     */
    public static function findByRoleId(int $id) {
        $query = "select u.*
                    from role_user ru
                    left join users u on ru.user_id = u.id
                    where role_id = ".$id." ";
        $result = DB::select(DB::raw($query));
        if ($result) {
            return $result;
        } else {
            return [];
        }
    }
}
