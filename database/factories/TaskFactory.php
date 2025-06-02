<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User; // Importe User se for usá-lo para user_id
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // Associa a um usuário criado pela UserFactory,
            // ou você pode passar o user_id ao chamar create() no seeder.
            // No seu TaskSeeder, você já está passando user_id, então
            // esta linha pode ser opcional aqui se você SEMPRE passar user_id.
            // Mas é bom ter um fallback.
            'title' => $this->faker->sentence(4), // <<--- IMPORTANTE: Define um título
            'description' => $this->faker->paragraph(2), // Define uma descrição
            'due_date' => $this->faker->optional(0.7)->dateTimeBetween('+1 day', '+1 month'), // 70% chance de ter data, entre amanhã e 1 mês
            'priority' => $this->faker->randomElement(['Baixa', 'Media', 'Alta']), // Define uma prioridade
            // created_at e updated_at são preenchidos automaticamente
        ];
    }
}
