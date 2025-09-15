<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Admin\Role;
use App\Models\Admin\Permission;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_name',
        'name',
        'phone',
        'email',
        'password',
        'profile',
        'balance',
        'max_score',
        'status',
        'is_changed_password',
        'agent_id',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // roles relation (many-to-many)
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // permissions relation (many-to-many)
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    // agent relation (self-referencing)
    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id');
    }

    // players relation (self-referencing)
    public function players()
    {
        return $this->hasMany(User::class, 'agent_id');
    }

    // vendor relation
    public function vendor()
    {
        return $this->hasOne(\App\Models\Admin\Vendor::class);
    }

    public function hasRole($role)
    {
        return $this->roles->contains('title', $role);
    }

    public function hasPermission($permission)
    {
        return $this->roles->flatMap->permissions->pluck('title')->contains($permission);
    }
}
