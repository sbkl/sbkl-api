<?php

namespace sbkl\SbklApi\Http\Middleware;

use Closure;

class Activated
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
        if ($userDeactivated = auth()->user()->deactivated || $plantDeactivated = auth()->user()->plant ? auth()->user()->plant->deactivated : false) {
            request()->user()->token()->revoke();
            $json = [
                'success' => false,
                'code' => 403,
                'errors' => [
                    'email' => $userDeactivated ? ['Your account has been deactivated.'] : ($plantDeactivated ? ['Your plant has been deactivated.'] : ['Unable to login.']),
                ],
            ];

            return response()->json($json, '422');
        }

        return $next($request);
    }
}
