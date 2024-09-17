<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class EventTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $data = [
            [
                'date' => '2024-10-10',
                'starttime' => '09:00:00',
                'endtime' => '17:00:00',
            ],
            [
                'date' => '2024-10-11',
                'starttime' => '09:00:00',
                'endtime' => '17:00:00',
            ]
        ];

        DB::table('events')->insert([
            [
                'id'       => 1,
                'name' => 'テストイベントタイトル',
                'organization' => 1,
                'place' => '浜松アクトシティ',
                'event_date' => json_encode($data),
                'approval' => 0,
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
        ]);
    }
}



