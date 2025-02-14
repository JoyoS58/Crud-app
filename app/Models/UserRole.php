<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserRole extends Pivot
{
    protected $table = 'user_role';
    protected $fillable = ['user_id', 'role_id'];

    public $timestamps = true;
}
