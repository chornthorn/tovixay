<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class Permission extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
