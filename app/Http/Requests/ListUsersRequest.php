<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListUsersRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		return auth()->check() && $this->user()->can('users.index');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules(): array
	{
		return [
			'per_page' => 'bail|nullable|integer|min:2|max:100',
			'name' => 'bail|nullable|string|max:255',
			'email' => 'bail|nullable|string|max:255',
			'contact' => 'bail|nullable|string|max:255',
		];
	}
}
