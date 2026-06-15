<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = Auth::user();
        
        if(!$user->hasRole($roles)) {

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Anda tidak memiliki akses ke halaman ini.'
                ], 403);
            }

            return redirect()->route('administrator.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }


        return $next($request);
    }
}
