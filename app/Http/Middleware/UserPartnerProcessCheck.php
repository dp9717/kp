<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserPartnerProcessCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $chk = \App\Models\ProcessAssign::where(['role_id'=>auth()->user()->userRole->role_id,'process_id'=>5])->count();
        if($chk){
            return $next($request);
        }
        return to_route('user.home')->with('failed','You do not have permission to access for this process.');
    }
}
