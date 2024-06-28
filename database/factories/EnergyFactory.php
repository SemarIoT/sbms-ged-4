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
        $currentDateTime = $currentDateTime ?: $this->faker->dateTimeBetween('-5 days'); // Set the initial dateTime

        // Increment the currentDateTime by 10 minutes
        $currentDateTime->add(new DateInterval('PT' . 5 . 'M'));

        $id_kwh++;
        if ($id_kwh > 4) {
            $id_kwh = 1;
        }

        return [
            'id_kwh' => $id_kwh,
            'i_A' => $this->faker->numberBetween(1, 4),
            'i_B' => $this->faker->numberBetween(1, 4),
            'i_C' => $this->faker->numberBetween(1, 4),
            'v_A' => $this->faker->numberBetween(210, 230),
            'v_B' => $this->faker->numberBetween(210, 230),
            'v_C' => $this->faker->numberBetween(210, 230),
            'p_A' => $this->faker->randomFloat(2, 0, 3),
            'p_B' => $this->faker->randomFloat(2, 0, 3),
            'p_C' => $this->faker->randomFloat(2, 0, 3),
            'pf_A' => $this->faker->randomFloat(1, 0, 1),
            'pf_B' => $this->faker->randomFloat(1, 0, 1),
            'pf_C' => $this->faker->randomFloat(1, 0, 1),
            'frekuensi' => $this->faker->numberBetween(50, 60),
            'reactive_power' => $this->faker->randomFloat(2, 0, 3),
            // 'created_at' => $this->faker->dateTimeInInterval('-2 month', '+2 month'),
            'created_at' => $currentDateTime,
        ];
    }
}
