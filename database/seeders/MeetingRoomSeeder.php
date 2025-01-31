<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MeetingRoom;

class MeetingRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         MeetingRoom::insert([
            ['name' => 'Meeting Room 1', 'capacity' => 3],
            ['name' => 'Meeting Room 2', 'capacity' => 10],
            ['name' => 'Meeting Room 3', 'capacity' => 15],
            ['name' => 'Meeting Room 4', 'capacity' => 2],
            ['name' => 'Meeting Room 5', 'capacity' => 1],
        ]);
    }
}
