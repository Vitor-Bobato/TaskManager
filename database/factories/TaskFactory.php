<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(2),
            'due_date' => $this->faker->optional(0.7)->dateTimeBetween('+1 day', '+1 month'),
            'priority' => $this->faker->randomElement(['Baixa', 'Media', 'Alta']),
        ];
    }
}
