<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGroupRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		return auth()->check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules(): array
	{
		return [
			'title' => 'bail|required|string|min:5|max:255',
			'crew_id' => 'bail|required|integer|exists:crews,id',
			'clients_virtual_count' => 'bail|nullable|integer|min:1',
		];
	}

	/**
	 * Get custom messages for validator errors.
	 *
	 * @return array
	 */
	public function messages(): array
	{
		return [
			'crew_id.required' => __('Must select a crew member.'),
			'crew_id.integer' => __('Must select a crew member.'),
		];
	}
}
