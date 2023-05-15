<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMealRequest extends FormRequest
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
			'meal_type_id' => 'bail|required|integer|exists:meal_types,id',
			'quantity' => 'bail|required|integer|min:1|max:2147483647',
			'to_model_type' => [
				'bail',
				'required',
				'string',
				// TODO: get the list of model that can be assigned
				// Rule::in([]),
			],
			// TODO: check if ID exists in table corresponding
			// to the model provided
			'to_model_id' => 'bail|required|integer',
			'sent_at' => 'bail|required|date_format:Y-m-d H:i:s',
		];
	}
}
