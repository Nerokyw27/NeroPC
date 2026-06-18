<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
class CekAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user login dan memiliki role 'admin'
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }
        abort(403, 'Akses Ditolak: Anda bukan Admin.');
    }
}