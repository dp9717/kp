<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    /*public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }*/

    public function handle(Request $request, Closure $next): Response
    {
        if(isset(auth()->user()->is_admin) && auth()->user()->is_admin==0){
            return $next($request);
        }
          
        return to_route('admin.login');//->with('failed','You do not have permission to access for this page.');
        /* return response()->view('errors.check-permission'); */
    }
}
