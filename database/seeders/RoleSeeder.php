<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'role_name' => 'Admin',
                'role_description' => 'Full Access',
            ],
            [
                'role_name' => 'Member',
                'role_description' => 'Feature',
            ],
            [
                'role_name' => 'User',
                'role_description' => 'User',
            ],
        ];
        
        foreach($data as $role){
            Role::create($role);
        }
    }
}
