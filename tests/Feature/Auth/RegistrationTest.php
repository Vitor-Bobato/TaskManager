<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase; // Para resetar o banco a cada teste
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Importe seu modelo User
use Tests\TestCase;
use Illuminate\Support\Str; // Import Str para gerar strings longas

class RegistrationTest extends TestCase
{
    use RefreshDatabase; // Garante que o banco de dados seja resetado para cada teste

    /**
     * Testa se um usuário pode se registrar com sucesso.
     *
     * @return void
     */
    public function test_user_can_register_successfully(): void
    {
        $userData = [
            'nome_completo' => 'Usuário Teste',
            'email' => 'teste@exemplo.com',
            'password' => 'senha123',
            'password_confirmation' => 'senha123', // Campo de confirmação de senha
        ];

        // Faz uma requisição POST para a rota de registro
        $response = $this->post(route('register.store'), $userData);

        // Verifica se o usuário foi redirecionado para a rota de login (conforme seu RegisterController)
        $response->assertRedirect(route('login'));

        // Verifica se uma mensagem de sucesso está na sessão
        $response->assertSessionHas('success', 'Usuário registrado com sucesso! Por favor, faça o login.');

        // Verifica se o usuário foi realmente criado no banco de dados
        $this->assertDatabaseHas('users', [
            'nome_completo' => 'Usuário Teste',
            'email' => 'teste@exemplo.com',
        ]);

        // Verifica se a senha foi hashada (opcional, mas bom para garantir)
        $user = User::where('email', 'teste@exemplo.com')->first();
        $this->assertTrue(Hash::check('senha123', $user->password));
    }

    /**
     * Testa se o registro falha com dados inválidos (ex: email já existente).
     *
     * @return void
     */
    public function test_user_registration_fails_if_email_already_exists(): void
    {
        // Cria um usuário primeiro para que o email já exista
        User::factory()->create(['email' => 'existente@exemplo.com']);

        $userData = [
            'nome_completo' => 'Outro Usuário',
            'email' => 'existente@exemplo.com', // Email que já existe
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
        ];

        $response = $this->post(route('register.store'), $userData);

        // Verifica se houve um erro de validação para o campo 'email'
        $response->assertSessionHasErrors('email');

        // Verifica se o usuário não foi redirecionado para login (ou seja, voltou para o formulário)
        // A validação do Laravel geralmente redireciona de volta (status 302)
        $response->assertStatus(302);

        // Garante que nenhum novo usuário com este nome foi criado (além do primeiro)
        $this->assertDatabaseCount('users', 1); // Apenas o usuário criado pela factory
    }

    /**
     * Testa se o registro falha se a confirmação de senha não corresponder.
     *
     * @return void
     */
    public function test_user_registration_fails_if_passwords_do_not_match(): void
    {
        $userData = [
            'nome_completo' => 'Usuário Senha Diferente',
            'email' => 'senhadiferente@exemplo.com',
            'password' => 'senha123',
            'password_confirmation' => 'outrasenha456', // Senhas diferentes
        ];

        $response = $this->post(route('register.store'), $userData);

        // Verifica se houve um erro de validação para o campo 'password' (devido à regra 'confirmed')
        $response->assertSessionHasErrors('password');
        $response->assertStatus(302); // Redirecionamento de volta
    }

    /**
     * Testa se o registro falha se campos obrigatórios não forem preenchidos.
     *
     * @return void
     */
    public function test_user_registration_fails_with_missing_required_fields(): void
    {
        $response = $this->post(route('register.store'), [
            // Sem 'nome_completo', 'email', 'password'
        ]);

        $response->assertSessionHasErrors(['nome_completo', 'email', 'password']);
        $response->assertStatus(302);
    }

    /**
     * Testa se o registro falha com uma quantidade excessiva de caracteres nos campos.
     *
     * @return void
     */
    public function test_user_registration_fails_with_excessive_characters(): void
    {
        // Gera uma string aleatória com 300 caracteres (assumindo max:255 para os campos)
        $longString = Str::random(1000);

        $userData = [
            'nome_completo' => $longString, // String muito longa
            'email' => $longString . '@exemplo.com', // Email também muito longo (parte local)
            'password' => 'senha123',
            'password_confirmation' => 'senha123',
        ];

        $response = $this->post(route('register.store'), $userData);

        // Verifica se houve errors de validação para 'nome_completo' e 'email'
        // (devido à regra 'max:255' no seu RegisterController)
        $response->assertSessionHasErrors(['nome_completo', 'email']);
        $response->assertStatus(302); // Redirecionamento de volta

        // Garante que nenhum usuário foi criado com esses dados longos
        $this->assertDatabaseMissing('users', [
            'email' => $longString . '@exemplo.com',
        ]);
    }
}
