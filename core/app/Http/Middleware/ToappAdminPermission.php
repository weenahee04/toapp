<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ToappAdminPermission
{
    public function handle(Request $request, Closure $next, string ...$permissions): Response
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return redirect()->route('toapp.admin.login');
        }

        if ($permissions && !$admin->hasAnyAccess($permissions)) {
            abort(403, 'You do not have permission to access this admin area.');
        }

        return $next($request);
    }
}
