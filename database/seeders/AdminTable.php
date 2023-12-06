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
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email'=> 'superadmin@gmail.com',
                'password'=> Hash::make('superadmin'),
                'user_type' => 1,
            ]

            // // manager
            // [
            //     'name'=> 'Owner',
            //     'email'=> 'owner@gmail.com',
            //     'password'=> Hash::make('owner'),
            //     'user_tpye' => 2,
            // ],
            // // User
            // [
            //     'name'=> 'User',
            //     'email'=> 'user@gmail.com',
            //     'password'=> Hash::make('user'),
            //     'user_tpye' => 3,
            // ],
        ]);
    }
}
