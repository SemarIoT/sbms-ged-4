<?php

namespace Database\Factories;

use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnergyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $id_kwh = 0;

        static $currentDateTime = null; // Initialize the currentDateTime
        $currentDateTime = $currentDateTime ?: $this->faker->dateTimeBetween('-2 days', 'now'); // Set the initial dateTime

        // Increment the currentDateTime by 10 minutes
        $currentDateTime->add(new DateInterval('PT' . 5 . 'M'));

        $id_kwh++;
        if ($id_kwh > 4) {
            $id_kwh = 1;
        }

        return [
            'id_kwh' => $id_kwh,
            'frekuensi' => $this->faker->numberBetween(50, 60),
            'arus' => $this->faker->numberBetween(1, 4),
            'tegangan' => $this->faker->numberBetween(210, 230),
            'active_power' => $this->faker->randomFloat(2, 0, 3),
            'reactive_power' => $this->faker->randomFloat(2, 0, 3),
            'apparent_power' => $this->faker->randomFloat(2, 0, 3),
            // 'created_at' => $this->faker->dateTimeInInterval('-2 month', '+2 month'),
            'created_at' => $currentDateTime,
        ];
    }
}
