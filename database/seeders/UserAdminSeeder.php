<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User::create([
        //     'name' => 'Administrateur',
        //     'email' => 'admin@admin.fr',
        //     'password' => Hash::make('user/user')
        // ]);
        // User::create([
        //     'name' => 'Administrateur 1',
        //     'email' => 'admin1@admin1.fr',
        //     'password' => Hash::make('user/user')
        // ]);
    }
}
