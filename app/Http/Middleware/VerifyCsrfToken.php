<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Contracts\Foundation\Application; // Necessário para app()
use Illuminate\Contracts\Encryption\Encrypter; // Necessário se você usar o construtor padrão

class VerifyCsrfToken extends Middleware
{
    /**
     * A aplicação Illuminate.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app; // Adicionado para consistência se você precisar do app instance

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Aqui você pode adicionar URIs específicas para serem excluídas globalmente, se necessário.
        // Exemplo:
        // '/stripe/*',
        // 'http://example.com/foo/bar',
        // 'http://example.com/foo/*',
    ];

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Contracts\Encryption\Encrypter  $encrypter
     * @return void
     */
    public function __construct(Application $app, Encrypter $encrypter) // Construtor padrão do Laravel
    {
        $this->app = $app;
        $this->encrypter = $encrypter; // O Middleware base usa $this->encrypter
    }

    /**
     * Determine if the session and input CSRF tokens match.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
// app/Http/Middleware/VerifyCsrfToken.php
    protected function tokensMatch($request)
    {
        if (app()->environment('testing') || app()->environment('cypress')) { // Adicione 'cypress' se usar esse env
            return true;
        }
        return parent::tokensMatch($request);
    }
}
