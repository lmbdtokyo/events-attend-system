<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class UsersTableSeeder extends Seeder
{
    /**
     * データベース初期値設定の実行
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'マスター管理者',
            'email' => 'akiyama@lmbd.tokyo',
            'password' => bcrypt('admin123456'),
            'type' => 'master',
            'organization' => 1,
            'auth' => 1,
        ]);
    }
}