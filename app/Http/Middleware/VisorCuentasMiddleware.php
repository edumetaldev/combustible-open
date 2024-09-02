<?php

namespace App\Http\Middleware;

use Closure;

class VisorCuentasMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if (Auth()->user()->rol == 'visor_cuentas') {
          return $next($request);
      }
      if (Auth()->user()->rol == 'administrador') {
          return $next($request);
      }

      return response()->view('forbiden', [], 403);
    }
}
