<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $user1 = User::where('email', 'test@example.com')->first();
        $user2 = User::where('email', 'email.ja.existe@example.com')->first();

        if ($user1) {
            Task::factory()->count(5)->create(['user_id' => $user1->id]);
        }
        if ($user2) {
            Task::factory()->count(3)->create(['user_id' => $user2->id]);
        }
        // Adicione mais tarefas para outros usuários se necessário
    }
}
