<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user')->insert([
            'nama' => 'Naufal Rivaldi',
            'username' => 'admin',
            'password' => Hash::make('admin'),
            'ttd' => 'ttd.png',
            'level' => 2,
            'remember_token' => Str::random(30),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => 1
        ]);
    }
}
