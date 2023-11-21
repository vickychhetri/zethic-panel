<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Role::where('name', 'admin')->exists()) {
            Role::create(['name' => 'admin']);
        }

        // Create an admin user
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('qwerty'),
        ]);

        // Assign the admin role to the admin user
        $admin->assignRole('admin');

    }
}
