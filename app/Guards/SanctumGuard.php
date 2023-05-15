<?php

declare(strict_types=1);

namespace App\Guards;

use Laravel\Sanctum\{Guard, Sanctum};

class SanctumGuard extends Guard
{
	/**
	 * Determine if the provided access token is valid.
	 *
	 * @param mixed $accessToken
	 *
	 * @return bool
	 */
	protected function isValidAccessToken($accessToken): bool
	{
		if (! $accessToken) {
			return false;
		}

		$last_seen = $accessToken->last_used_at;

		if (is_null($last_seen)) {
			$last_seen = $accessToken->created_at;
		}

		$isValid =
			(! $this->expiration || $last_seen->gt(now()->subMinutes($this->expiration)))
			&& (! $accessToken->expires_at || ! $accessToken->expires_at->isPast())
			&& $this->hasValidProvider($accessToken->tokenable);

		if (is_callable(Sanctum::$accessTokenAuthenticationCallback)) {
			$isValid = (bool) (Sanctum::$accessTokenAuthenticationCallback)($accessToken, $isValid);
		}

		return $isValid;
	}
}
