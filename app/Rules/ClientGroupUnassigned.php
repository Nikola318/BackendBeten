<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Client;
use Illuminate\Contracts\Validation\InvokableRule;

class ClientGroupUnassigned implements InvokableRule
{
	/**
	 * Run the validation rule.
	 *
	 * @param string $attribute
	 * @param mixed $value
	 * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
	 *
	 * @return void
	 */
	public function __invoke($attribute, $value, $fail)
	{
		// $value is the client id
		// we want to check if the client has a value in group_id column
		if (Client::where('id', $value)->whereNotNull('group_id')->exists()) {
			$fail(__('Client already exists in another group.'));
		}
	}
}
