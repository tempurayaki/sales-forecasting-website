<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Check admin role
        if (in_array('admin', $roles)) {
            if ($user->role === 'admin') { // Direct attribute check
                return $next($request);
            }
        }
        
        // Check user role
        if (in_array('user', $roles) && $user->role === 'user') {
            return $next($request);
        }

        abort(403, 'Unauthorized access');
    }
}