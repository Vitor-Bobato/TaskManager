<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'priority',
        'user_id', // Adicionando a coluna user_id para associar a tarefa ao usuário
        'completed', // Adicionando a coluna completed para indicar se a tarefa foi concluída
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
