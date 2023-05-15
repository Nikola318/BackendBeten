<?php

declare(strict_types=1);

namespace App\Rules;

use App\Models\Client;
use Illuminate\Contracts\Validation\Rule;

class ClientAssignedToGroup implements Rule
{
	/** @var int $group_id the group ID to check for */
	private int $group_id;

	/**
	 * Create a new rule instance.
	 *
	 * @return void
	 */
	public function __construct(int $group_id)
	{
		$this->group_id = $group_id;
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param string $attribute
	 * @param mixed $value
	 *
	 * @return bool
	 */
	public function passes($attribute, $value): bool
	{
		return Client::where([
			'id' => $value,
			'group_id' => $this->group_id,
		])->exists();
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message(): string
	{
		return __('Client is not assigned to this group.');
	}
}
