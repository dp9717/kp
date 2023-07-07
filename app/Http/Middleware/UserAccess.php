<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(isset(auth()->user()->is_admin) && auth()->user()->is_admin==1){
            if (isset(auth()->user()->id) && auth()->user()->status==2) {
                return to_route('user.login')->with('failed','Please wait for system approval. Account will be activated soon.');
            }
            return $next($request);
        }else if (isset(auth()->user()->id) && auth()->user()->is_admin==0) {
            return to_route('admin.home');
        }
        return to_route('user.login');//->with('failed','You do not have permission to access for this page.');
        /* return response()->view('errors.check-permission'); */
    }
}
