<?php
//
//namespace App\Http\Middleware;
//
//use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
//use Illuminate\Contracts\Foundation\Application;
//use Illuminate\Contracts\Encryption\Encrypter;
//
//class VerifyCsrfToken extends Middleware
//{
//    protected $app;
//
//    protected $except = [
//    ];
//
//    public function __construct(Application $app, Encrypter $encrypter)
//    {
//        $this->app = $app;
//        $this->encrypter = $encrypter;
//    }
//
//    protected function tokensMatch($request)
//    {
//        if (app()->environment('testing') || app()->environment('cypress'))
//        {
//            return true;
//        }
//        return parent::tokensMatch($request);
//    }
//}
namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        // Aqui você pode adicionar rotas específicas para ignorar o CSRF em produção, se necessário.
        // Ex: 'stripe/*',
    ];

    /**
     * Determine if the request has a URI that should be excluded from CSRF verification.
     *
     * Este é o método recomendado pelo Laravel para adicionar exceções dinâmicas.
     * Estamos a sobrescrevê-lo para desativar a verificação CSRF quando
     * a aplicação está no ambiente 'testing'.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        // Se o ambiente da aplicação for 'testing' (definido no seu .env.testing),
        // este método retorna 'true', o que diz ao Laravel para ignorar a verificação CSRF
        // para absolutamente TODAS as rotas.
        if ($this->app->environment('testing')) {
            return true;
        }

        // Para todos os outros ambientes (como 'local' ou 'production'),
        // a verificação CSRF funciona normalmente, usando a lista da propriedade $except acima.
        return parent::inExceptArray($request);
    }
}
