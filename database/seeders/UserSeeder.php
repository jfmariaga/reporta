<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=> 'Juan Mariaga',
            'email'=>'analista2.tecnologia@panalsas.com',
            'email_verified_at' => now(),
            'password'=>bcrypt('00272259'),
            'remember_token' => Str::random(10),
        ])->assignRole('Admin');
    }
}
