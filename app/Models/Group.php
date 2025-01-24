<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    // Primary key
    protected $primaryKey = 'group_id';

    public $incrementing = true;

    // Kolom yang dapat diisi secara massal
    protected $fillable = ['group_name', 'group_description', 'is_active', 'user_id'];

    // Relasi ke model Member
    public function members()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id')
            ->using(GroupUser::class);
    }

    // Relasi ke model User
    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id');
    }
    public function pivotUsers()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id')
            ->withPivot('user_id', 'group_name');
    }
}
