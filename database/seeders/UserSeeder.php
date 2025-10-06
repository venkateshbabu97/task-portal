<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRole = Role::where('name', 'Admin')->first();
        $requesterRole = Role::where('name', 'Requester')->first();
        $contributorRole = Role::where('name', 'Contributor')->first();

        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Requester User',
            'email' => 'requester@example.com',
            'password' => Hash::make('password'),
            'role_id' => $requesterRole->id,
        ]);

        User::create([
            'name' => 'Contributor User',
            'email' => 'contributor@example.com',
            'password' => Hash::make('password'),
            'role_id' => $contributorRole->id,
        ]);
    }
}
