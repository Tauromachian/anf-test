<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Line;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'line_id' => Line::inRandomOrder()->first()->id,
            'user_id' => User::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(array('attending', 'attended', 'cancelled', 'pending')),
            'service' => $this->faker->randomElement(array('Atención a la población', 'Recogida de documento')),
            'procedure' => $this->faker->randomElement(array('Dictamen técnico', 'Habitable-Utilizable', 'Licencia de obra', 'Regulaciones urbanas')),
            'boss' => $this->faker->boolean(50),
            'ticket_number' => $this->faker->numberBetween(1, 100),
        ];
    }
}
