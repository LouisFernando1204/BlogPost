<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // kelebihan menggunakan middleware yaitu ketika kita ingin memberi otorisasi untuk banyak method sekaligus
        // tapi kurang fleksibel
        // if (auth()->guest() || auth()->user()->username !== 'louisfernando') {
        //     abort(403);
        //     // ini adalah pesan forbidden/terlarang karena belum login
        // }

        // ini setelah ditambahkkan fiels is_admin di table users
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
            // ini adalah pesan forbidden/terlarang karena belum login
        }
        return $next($request);
    }
}
