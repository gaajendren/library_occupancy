<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $required_role = null): Response
    {
        $user_role = $request->user()->role;

    

        if( $user_role == $required_role){
            return $next($request);
        }
        else{
          return $user_role == 0 ? redirect()->route('student.dashboard') : redirect()->route('staff.dashboard') ;
        }
        
       
    }
}
