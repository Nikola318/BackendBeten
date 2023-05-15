<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateServiceCommitRequest extends FormRequest
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
			'service_id' => 'bail|required|integer|exists:services,id',
			'badge' => 'bail|required|string|min:3|max:255',
			'schedule_at' => 'bail|required|date_format:Y-m-d H:i:s',
			'from_location' => 'bail|required|string|min:3|max:255',
			'supervisor_id' => 'bail|required|integer|exists:users,id',
			'phase_id' => 'bail|nullable'
		];
	}
}
