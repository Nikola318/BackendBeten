<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
			'city_id' => 'bail|required|integer|exists:cities,id',
			// We must receive only one of these 3 dates
			'before_date' => 'bail|prohibits:exact_date,after_date|date_format:Y-m-d',
			'exact_date' => 'bail|prohibits:before_date,after_date|date_format:Y-m-d',
			'after_date' => 'bail|prohibits:exact_date,before_date|date_format:Y-m-d',
		];
	}

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array<string, string>
	 */
	public function messages(): array
	{
		return [
			'before_date.prohibits' => __('Only one date is allowed'),
			'exact_date.prohibits' => __('Only one date is allowed'),
			'after_date.prohibits' => __('Only one date is allowed'),
		];
	}
}
