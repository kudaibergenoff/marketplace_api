<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if ($user && $user->hasAnyRole($roles)) {
            return $next($request);
        }

        return response()->json(['message' => 'У вас нет доступа.'], 200);
    }
}
