<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerificarDatosCompletos
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->email == null)
        {
            return redirect()->route('llenar-datos-personales.form');
        }
        
        return $next($request);
    }
}
