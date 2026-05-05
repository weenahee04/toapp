<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RegistrationCheckStep
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
        $user_register = session()->get('user_register');
        
        $currentRouteName = $request->route()->getName();
    
        if (isset($user_register['profile_complete'])) {
           
            if ($user_register['profile_complete'] == 3 && $currentRouteName == 'user.register3') {
                return  $next($request);
            }
    
            return  $currentRouteName !==  'user.data' ? to_route('user.data'):$next($request);
            
        }
    
        return to_route('user.register');
    }
}
