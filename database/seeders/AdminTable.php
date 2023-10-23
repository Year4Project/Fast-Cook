<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            // Administrator
            [
                'name' => 'SuperAdmin',
                'email'=> 'superadmin@example.com',
                'password'=> Hash::make('superadmin'),
            ],

            // manager
            [
                'name'=> 'Owner',
                'email'=> 'owner@example.com',
                'password'=> Hash::make('owner'),
            ],
            // User
            [
                'name'=> 'User',
                'email'=> 'user@example.com',
                'password'=> Hash::make('user'),
            ],
        ]);
    }
}
