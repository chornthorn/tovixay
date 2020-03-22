<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, int $id)
 * @method static search($search)
 * @method static truncate()
 */
class Location extends Model
{
    protected $table = 'locations';
    protected $fillable = ['location_code', 'location_name', 'location_status', 'user_id'];

    public function scopeSearch($query,$search){
        return $query->where('location_code','like','%'.$search.'%')
            ->orWhere('location_name','like','%'.$search.'%');
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
