<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory;

    // Custom primary key
    protected $primaryKey = 'user_id';

    // Disable timestamps if not used in your DB
    public $timestamps = true;

    // Mass assignable columns
    protected $fillable = ['role_id','name', 'email', 'password', 'profile'];

    // Set the data types for attributes
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Set default password hashing logic when saving
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->isDirty('password') && !empty($model->password)) {
                $model->password = Hash::make($model->password);
            }
        });
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'group_user', 'user_id', 'group_id')
            ->using(GroupUser::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }

    public function pivotGroups()
    {
        return $this->belongsToMany(Group::class, 'group_user', 'user_id', 'group_id')
            ->withPivot('group_id', 'group_name');
    }
}
