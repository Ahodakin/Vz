<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        "/devis/search",
        "/devis/search/sinistre",
        "/devis/auto/getquotation",
        "/devis/moto/getquotation",
        "/call-me"
    ];
}
