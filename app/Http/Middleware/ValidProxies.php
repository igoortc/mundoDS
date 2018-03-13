<?php namespace App\Http\Middleware;
use Closure;
class ValidProxies {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// Proxies
		$request->setTrustedProxies([ $request->getClientIp() ]);
		return $next($request);
	}
}