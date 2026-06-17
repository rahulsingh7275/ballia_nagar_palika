<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'user', 'label' => 'User'],
            ['name' => 'operator', 'label' => 'Operator'],
            ['name' => 'checker', 'label' => 'Checker'],
            ['name' => 'department_head', 'label' => 'Department Head'],
            ['name' => 'admin', 'label' => 'Admin'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role['name']], ['label' => $role['label']]);
        }

        $adminRole = Role::where('name', 'admin')->first();

        User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'System Admin',
            'password' => Hash::make('password'),
            'role_id' => $adminRole?->id,
        ]);
        User::firstOrCreate([
            'email' => 'operator@example.com',
        ], [
            'name' => 'Operator',
            'password' => Hash::make('password'),
            'role_id' => 2,
        ]);
        User::firstOrCreate([
            'email' => 'checker@example.com',
        ], [
            'name' => 'checker',
            'password' => Hash::make('password'),
            'role_id' => 3,
        ]);
    }
}
