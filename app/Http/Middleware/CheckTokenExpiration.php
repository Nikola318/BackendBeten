<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CheckTokenExpiration
{
	/**
	 * Handle an incoming request.
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
	 *
	 * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
	 */
	public function handle(Request $request, Closure $next)
	{
		if (auth()->check()) {
			$currentTime = now();
			if (!Cache::has(auth()->user()->id)) {
				Cache::put(auth()->user()->id, $currentTime);
				return $next($request);
			}

			$lastCall = Cache::get(auth()->user()->id);
			if ($currentTime->diffInMinutes($lastCall) > 15) {
				$request->user()->currentAccessToken()->delete();
				Cache::forget(auth()->user()->id);
				return response()->json([
					'status' => 'success'
				]);
			}
			Cache::put(auth()->user()->id, $currentTime);
		}
		return $next($request);
	}
}
