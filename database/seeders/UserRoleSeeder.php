<?php

namespace Database\Seeders;

use App\Models\UserRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('name', 'Admin')->first();
        $role = Role::where('role_name', 'Admin')->first();
        UserRole::create(
            [
            'user_id'=>$user->user_id,
            'role_id'=>$role->role_id,
            ]);
    }
}
