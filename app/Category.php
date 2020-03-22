<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @method static paginate()
 * @method static find(int $id)
 * @method static where(string $string, string $string1, string $string2)
 * @method static truncate()
 * @method static create(array $array)
 */
class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable = ['id','category_name', 'category_status', 'user_id'];
    public $incrementing = false;

    public function scopeSearch($query,$search){
        return $query->where('id','like','%'.$search.'%')
            ->orWhere('category_name','like','%'.$search.'%');
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
