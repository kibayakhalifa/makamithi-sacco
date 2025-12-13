<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create test users with different roles
        $users = [
            
            [
                'name' => 'Chairman Maina',
                'email' => 'chairman@makamithi.com',
                'password' => Hash::make('password'),
                'role' => 'chairman',
                'employee_number' => 'EMP002',
            ],
            [
                'name' => 'Secretary Kamau',
                'email' => 'secretary@makamithi.com',
                'password' => Hash::make('password'),
                'role' => 'secretary',
                'employee_number' => 'EMP004',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}