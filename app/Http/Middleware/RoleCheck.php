<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login');
        }

        $user = Auth::user();

        // Super admin has full access everywhere
        if ($user->role === 'super_admin') {
            return $next($request);
        }

        if (!in_array($user->role, $roles)) {
            abort(403, 'अनधिकृत पहुंच: आपके पास इस अनुभाग को देखने की अनुमति नहीं है। / Unauthorized access: you lack the required role permission.');
        }

        return $next($request);
    }
}
