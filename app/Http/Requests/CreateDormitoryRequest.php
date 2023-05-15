<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDormitoryRequest extends FormRequest
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
			'title' => 'bail|required|string|min:3|max:255',
			'phones' => 'bail|required|string|min:7|max:255',
			'city_id' => 'bail|required|integer|exists:cities,id',
			'location' => 'bail|required|string|min:3|max:255',
			'coordinate' => 'bail|nullable|regex:/^(-?\d+(\.\d+)?),\s*(-?\d+(\.\d+)?)$/',
			'is_active' => 'bail|required|boolean',
		];
	}
}
