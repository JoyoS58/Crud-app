<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::where('role_name', 'Admin')->first();
        // Menambahkan satu pengguna dengan data yang dibutuhkan
        User::create(
            [
            'role_id'=>$admin->role_id,
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => 'admin123', 
        ]
    );
    $users = User::factory()->count(50)->create();
    }
}
