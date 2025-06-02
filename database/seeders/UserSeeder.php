<?php
namespace Database\Seeders;
// database/seeders/UserSeeder.php
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([ // Usuário padrão para testes gerais
            'nome_completo' => 'Usuário de Teste Padrão',
            'email' => 'test@example.com',
            'password' => Hash::make('Password123!'),
        ]);

        // Crie o usuário específico para o teste de "email já existe"
        User::factory()->create([
            'nome_completo' => 'Usuário Email Duplicado',
            'email' => 'email.ja.existe@example.com', // E-mail que você usará no teste de duplicação
            'password' => Hash::make('Password123!'),
        ]);

        User::factory()->create([
            'nome_completo' => 'User A',
            'email' => 'userA@example.com', // E-mail que você usará no teste de duplicação
            'password' => Hash::make('Password123!'),
        ]);

        User::factory()->create([
            'nome_completo' => 'User B',
            'email' => 'userB@example.com', // E-mail que você usará no teste de duplicação
            'password' => Hash::make('Password123!'),
        ]);

        // Adicione mais usuários se necessário
    }
}
