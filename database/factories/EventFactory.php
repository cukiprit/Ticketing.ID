<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Event::class;

    public function definition(): array
    {
        $eventNames = [
            'Seminar Kewirausahaan',
            'Workshop Digital Marketing',
            'Konser Musik Indie',
            'Pameran Seni Kontemporer',
            'Festival Kuliner Nusantara',
            'Konferensi Teknologi Nasional',
            'Pelatihan Kepemimpinan',
            'Lomba Startup Digital',
            'Turnamen E-sports',
            'Bazaar UMKM Kreatif'
        ];

        $locations = [
            'Jakarta Convention Center',
            'Bandung Creative Hub',
            'Surabaya Town Square',
            'Yogyakarta Cultural Center',
            'Bali Creative Space',
            'Medan Heritage Hall',
            'Makassar Innovation Center',
            'Semarang Art Gallery',
            'Palembang Trade Center',
            'Denpasar Exhibition Hall'
        ];

        return [
            'acara' => $this->faker->randomElement($eventNames),
            'deskripsi' => $this->faker->paragraphs(3, true),
            'tanggal_acara' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'lokasi' => $this->faker->randomElement($locations),
            'status' => $this->faker->randomElement(['draft', 'published', 'cancelled']),
        ];
    }
}
