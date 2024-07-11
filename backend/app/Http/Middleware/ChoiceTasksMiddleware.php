<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChoiceTasksMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            
            $request->validate([
                'done' => 'nullable|in:0,1'
            ]);

            return $next($request);
        } catch (\Exception) {
          
            return response()->json([
                'Error' => 'the done parameter, when used, must be 0 or 1',
            ], 400);
        }
        
        
    }
}
