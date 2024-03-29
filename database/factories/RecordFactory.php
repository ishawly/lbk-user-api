<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\record>
 */
class RecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'         => random_int(1001, 1020),
            'reciprocal_name' => $this->faker->name,
            'type'            => (random_int(0, 9) % 2) ? -1 : 1,
            'category_id'     => random_int(1, 10),
            'amount'          => random_int(100, 5000000),
            'transaction_at'  => $this->faker->date(),
            'remarks'         => $this->faker->text(),
        ];
    }
}
