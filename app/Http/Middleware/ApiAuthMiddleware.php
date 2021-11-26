<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::where('remember_token',$request->remember_token)->first();

        if( isset( $user ) ) {
            return $next($request);
        }

        return response()->json( ['error' => 'auth errror'] , 401 );
    }
}
