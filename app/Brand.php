<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static search($search)
 * @method static create(array $array)
 * @method static find(int $id)
 * @method static where(string $string, int $id)
 * @method static truncate()
 */
class Brand extends Model
{
    protected $table = 'brands';
    protected $fillable = ['brand_code', 'brand_name', 'brand_status', 'user_id'];

    public function scopeSearch($query,$search){
        return $query->where('brand_code','like','%'.$search.'%')
            ->orWhere('brand_name','like','%'.$search.'%');
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
