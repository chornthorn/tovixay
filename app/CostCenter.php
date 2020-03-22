<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static truncate()
 */
class CostCenter extends Model
{
    protected $table = 'cost_centers';
    protected $fillable = ['costcenter_code', 'costcenter_name', 'costcenter_status', 'user_id'];

    public function scopeSearch($query,$search){
        return $query->where('costcenter_code','like','%'.$search.'%')
            ->orWhere('costcenter_name','like','%'.$search.'%');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
