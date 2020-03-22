<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @method static find(int $id)
 * @method static where(string $string, int $id)
 * @method static search($search)
 */
class Status extends Model
{
    protected $table = 'statuses';
    protected $fillable = ['status_code', 'status_name', 'status_status', 'user_id'];

    public function scopeSearch($query,$search){
        return $query->where('status_code','like','%'.$search.'%')
            ->orWhere('status_name','like','%'.$search.'%');
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
