<?php 

namespace App\Http\Middleware;

use Closure;

class HttpsProtocol {

    public function handle($request, Closure $next)
    {
        return redirect()->secure($request->getRequestUri());
    }
}