<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Encryption\Encrypter;

class VerifyCsrfToken extends Middleware
{
    protected $app;

    protected $except = [
    ];

    public function __construct(Application $app, Encrypter $encrypter)
    {
        $this->app = $app;
        $this->encrypter = $encrypter;
    }

    protected function tokensMatch($request)
    {
        if (app()->environment('testing') || app()->environment('cypress'))
        {
            return true;
        }
        return parent::tokensMatch($request);
    }
}
