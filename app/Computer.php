<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static search($search)
 * @method static where(string $string, int $id)
 * @method static truncate()
 * @method static find($id)
 */
class Computer extends Model
{
    protected $table = 'computers';

    public function scopeSearch($query, $search)
    {
        return $query->where('monitor_item', 'like', '%' . $search . '%')
            ->orWhere('mainboard_item', 'like', '%' . $search . '%');
    }
    public function asset()
    {
        return $this->hasOne(Asset::class);
    }

    public function scopeAssets($query,$id)
    {
        return $query->where('asset_id',$id);
    }
}
