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
        User::create([
            'nome_completo' => 'Usuário Duplicado Teste',
            'email' => 'email.ja.existe@example.com',
            'password' => Hash::make('Password123!'),
        ]);
        // Crie outros usuários se necessário
    }
}
