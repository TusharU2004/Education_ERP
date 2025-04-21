<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

     public function handle($request, Closure $next, ...$guards)
     {
         // Check authentication as usual
         if (!auth()->check()) {
             return redirect()->route('login')->with('error', 'You must log in first.');
         }
 
         // Continue to next middleware/controller and add no-cache headers
         $response = $next($request);
 
         return $response->header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate')
                         ->header('Pragma', 'no-cache')
                         ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');
     }
     
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
        
    }
}
