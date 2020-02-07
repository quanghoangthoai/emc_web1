<?php

namespace App\Http\Middleware;

use Closure;

class AdminCP
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (auth('admin')->check()) {
            return $next($request);
        }
        return redirect()->route('mod_user.admin.login', ['redirect_to' => base64_encode(url()->current())]);
    }
}