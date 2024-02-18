<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        // $user = Auth::user();
        // if ($user->hasRole($role)) {
        //     return $next($request);
        // }

        // return redirect('home')->with('error', "You don't have admin access.");

        if ($request->user()->role !== $role) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
