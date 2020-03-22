<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static find(string $string)
 */
class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'description'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function scopeSearch($query,$search){
        return $query->where('name','like','%'.$search.'%')
            ->orWhere('description','like','%'.$search.'%');
    }
}
