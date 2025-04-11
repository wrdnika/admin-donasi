<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Session;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('token')) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
