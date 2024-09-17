<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class initUsersauthmasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usersauthmaster')->insert([
            [
                'id'       => 1,
                'name' => '編集・出力・閲覧',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id'       => 2,
                'name' => '出力・閲覧',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'id'       => 3,
                'name' => '閲覧',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ]);
    }
}
