<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CreateVehicleRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		return auth()->check() && $this->user()->can('vehicles.create');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules(): array
	{
		return [
			'model' => 'bail|required|string|min:2|max:255',
			'registration' => [
				'bail',
				'required',
				'string',
				'min:3',
				'max:255',
				Rule::unique('vehicles')->ignore($this->id, 'id')
			],
			'manufacturer' => 'bail|required|string|min:5|max:255',
			'year' => 'bail|required|date_format:Y',
			'badge' => 'bail|required|integer|min:3|max:2147483647',
			'passengers' => 'bail|nullable|integer|min:1|max:2147483647',
		];
	}
}
