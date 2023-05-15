<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHospitalityRequest extends FormRequest
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
			'description' => 'bail|string|min:5|max:255',
			'required_date' => 'bail|required|date_format:Y-m-d',
			// TODO: figure out what the maximum quantity is
			// Can be decimal
			'quantity' => 'bail|required|decimal:0,2|min:1|max:999999',
			// TODO: replace by users table if required
			'received_by' => 'bail|required|integer|exists:crews,id',
			'extra' => 'bail|nullable|string|min:3|max:65535', // mysql max
			// Hospitalities_transaction => model type can be crew or client
		];
	}
}
