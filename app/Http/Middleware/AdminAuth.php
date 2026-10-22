<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('admin.login')->with('error', 'कृपया व्यवस्थापक कक्ष में प्रवेश के लिए लॉगिन करें / Please login to access CMS.');
        }

        if (!Auth::user()->is_active) {
            Auth::logout();
            return redirect()->route('admin.login')->with('error', 'आपका खाता निष्क्रिय है। कृपया व्यवस्थापक से संपर्क करें। / Your account is inactive.');
        }

        return $next($request);
    }
}
