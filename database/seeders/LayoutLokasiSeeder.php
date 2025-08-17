<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\LayoutLokasi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayoutLokasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = Event::all();

        foreach ($events as $event) {
            // Create 80 seats for each event (2 sections × 4 rows × 10 numbers)
            LayoutLokasi::factory()
                ->count(80)
                ->withSpecificLayout()
                ->create(['event_id' => $event->id]);
        }
    }
}
