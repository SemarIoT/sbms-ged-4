<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EnergyKwhFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static $dailyTotals = [1 => 0, 2 => 0, 3 => 0, 4 => 0];
        static $date = null;
        static $id_kwh = 1;

        if (is_null($date)) {
            // Start from a past date, e.g., 100 days ago
            $date = today()->subDays(100);
        } else {
            $id_kwh++;
            if ($id_kwh > 4) {
                $id_kwh = 1;
                $date->addDay();
            }
        }

        $increment = $this->faker->numberBetween(200, 12000);
        $dailyTotals[$id_kwh] += $increment;

        return [
            'id_kwh' => $id_kwh,
            'total_energy' => $dailyTotals[$id_kwh],
            'created_at' => $date->copy(),
            'updated_at' => $date->copy(),
        ];
    }
}
