<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		return auth()->check() && $this->user()->can('users.create');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules(): array
	{
		return [
			'name' => 'bail|required|string|min:3|max:255',
			'email' => 'bail|required|email|unique:users,email',
			// Password validation rules
			'password' => [
				'bail',
				'required',
				'confirmed',
				Password::min(8)
					->letters()
					->numbers()
			],
			'is_active' => 'bail|nullable|boolean',
			'contact' => 'bail|required|min:5|max:255',
		];
	}
}
