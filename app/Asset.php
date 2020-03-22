<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static search($search)
 * @method static where(string $string, int $id)
 * @method static find(int $id)
 * @method static truncate()
 * @method static statuses(string $string)
 * @method static categories(string $string)
 */
class Asset extends Model
{
    protected $table = 'assets';
//    protected $fillable = ['brand_code', 'brand_name', 'brand_status', 'user_id'];

    public function scopeSearch($query, $search)
    {
        return $query->where('asset_code', 'like', '%' . $search . '%')
            ->orWhere('asset_name', 'like', '%' . $search . '%');
    }
    public function scopeCategories($query, $id)
    {
        return $query->where('category_id',$id);
    }

    public function scopeStatuses($query,$id)
    {
        return $query->where('status_id', $id);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function model()
    {
        return $this->belongsTo(AssetModel::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function costcenter()
    {
        return $this->belongsTo(CostCenter::class);
    }
    public function computer()
    {
        return $this->belongsTo(Computer::class);
    }
}
