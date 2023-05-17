<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug', 'name', 'module_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_permissions');
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

}
