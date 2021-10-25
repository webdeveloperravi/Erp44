<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GetUtubeToken
{

    public function handle(Request $request, Closure $next)
    {

        if (isset($_COOKIE['utubeAccessTokenn'])) {
            return $next($request);
        } else {
            return redirect()->route('9gem_get_youtube_token');
        }
    }
}
