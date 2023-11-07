<?php

namespace App\Http\Middleware\Users;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {  
      
        if ((auth()->check()) &&( auth()->user()->isAdmin())) {

            return $next($request);
}
            return response()->json(['message' => 'Unauthorized']);
    }
}
