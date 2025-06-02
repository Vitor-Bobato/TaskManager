<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Coluna para o ID do usuário
            $table->string('title');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->enum('priority', ['Alta', 'Media', 'Baixa']) -> default('Baixa');
            $table->timestamps();

            // Chave estrangeira para o usuário
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade'); // Excluir tarefas se o usuário for excluído
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
