<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // If your primary key is not 'id', specify the custom primary key
    protected $primaryKey = 'role_id';

    // Enable timestamps if your table has created_at and updated_at columns
    public $timestamps = true;

    // Define the columns that are mass assignable
    protected $fillable = ['role_name', 'role_description'];

    // Many-to-many relationship with User model
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_role', 'role_id', 'user_id');
    }
}
