<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static search($search)
 * @method static where(string $string, int $id)
 * @method static create(array $array)
 * @method static truncate()
 */
class AssetModel extends Model
{
    protected $table = 'asset_models';
    protected $fillable = ['model_code', 'model_name', 'model_status', 'user_id'];


    public function scopeSearch($query,$search){
        return $query->where('model_code','like','%'.$search.'%')
            ->orWhere('model_name','like','%'.$search.'%');
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
