<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\LevelUser;

class Cek_login
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    /*public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }*/
    public function handle(Request $request, Closure $next, $roles)
    {
        if (!Auth::check()) {
            return redirect('auth.login');
        }
        $user = Auth::user();

        if($user->level == $roles)
            return $next($request);


        return redirect('auth.login')->with('error',"Akses ditolak");
    }
}
