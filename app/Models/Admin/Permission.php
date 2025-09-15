<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Role;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
