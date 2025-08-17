<?php

namespace Database\Factories;

use App\Models\LayoutLokasi;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LayoutLokasi>
 */
class LayoutLokasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = LayoutLokasi::class;

    public function definition(): array
    {
        $sections = ['VIP', 'Reguler'];
        $rows = ['A', 'B', 'C', 'D'];
        $numbers = range(1, 10);

        return [
            'section' => $this->faker->randomElement($sections),
            'row' => $this->faker->randomElement($rows),
            'number' => $this->faker->randomElement($numbers),
            'harga' => fn (array $attributes) => $attributes['section'] === 'VIP'
                ? $this->faker->numberBetween(500000, 1000000)
                : $this->faker->numberBetween(100000, 300000),
            'status' => $this->faker->randomElement(['available', 'booked', 'blocked']),
        ];
    }

    public function withSpecificLayout()
    {
        return $this->state(function (array $attributes) {
            static $combinations = [];
            $sections = ['VIP', 'Reguler'];
            $rows = ['A', 'B', 'C', 'D'];
            $numbers = range(1, 10);

            // Get all possible combinations
            if (empty($combinations)) {
                foreach ($sections as $section) {
                    foreach ($rows as $row) {
                        foreach ($numbers as $number) {
                            $combinations[] = [
                                'section' => $section,
                                'row' => $row,
                                'number' => $number,
                            ];
                        }
                    }
                }
                shuffle($combinations);
            }

            // Get the next combination
            $combination = array_shift($combinations);

            return array_merge($combination, [
                'harga' => $combination['section'] === 'VIP'
                    ? $this->faker->numberBetween(500000, 1000000)
                    : $this->faker->numberBetween(100000, 300000),
                'status' => 'available',
            ]);
        });
    }
}
