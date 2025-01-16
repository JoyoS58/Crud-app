<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $primaryKey = 'activity_id';
    protected $fillable = ['activity_name', 'description', 'group_id', 'user_id'];

    // Relasi dengan Group
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    // Relasi dengan User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
