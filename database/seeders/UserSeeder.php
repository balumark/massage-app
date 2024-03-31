<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {        
        User::factory()->create([
            'name' => 'Balu',
            'email' => 'balumark111@gmail.com',
            'password' => Hash::make('123456789'),
        ]);
        User::factory()->count(30)->create();
    }
}
