<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (session()->has('locale') && in_array(session('locale'), ['es', 'en'])) {
            App::setLocale(session('locale'));
        } else {
            App::setLocale(config('app.locale'));
            session(['locale' => config('app.locale')]);
        }

        return $next($request);
    }
}
