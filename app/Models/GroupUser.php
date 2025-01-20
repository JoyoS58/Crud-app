<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupUser extends Pivot
{
    protected $table = 'group_user';
    protected $fillable = ['group_id', 'user_id'];

    public $timestamps = true;

    public function users()
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id', 'user_id')
            ->using(GroupUser::class);
    }
}
