<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'nome_completo' => 'Usuário Teste',
            'email' => 'teste@example.com',
            'password' => bcrypt('senha123'),
        ]);

        // Adicione outros seeders se necessário
    }
}
