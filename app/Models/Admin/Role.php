<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Permission;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
