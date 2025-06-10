<?php
namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'nome_completo' => 'Usuário de Teste Padrão',
            'email' => 'test@example.com',
            'password' => 'Password123!',
        ]);

        User::factory()->create([
            'nome_completo' => 'Usuário Email Duplicado',
            'email' => 'email.ja.existe@example.com',
            'password' => 'Password123!',
        ]);

        User::factory()->create([
            'nome_completo' => 'User A',
            'email' => 'userA@example.com',
            'password' => 'Password123!',
        ]);

        User::factory()->create([
            'nome_completo' => 'Usuário B Teste',
            'email' => 'userB@example.com',
            'password' => 'Password123!',
        ]);

    }
}
