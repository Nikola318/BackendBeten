<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		return auth()->check() && $this->user()->can('clients.create');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules(): array
	{
		return [
			'fullname' => 'bail|required|string|min:3|max:50',
			'country_id' => [
				'bail',
				'required',
				'integer',
				'exists:countries,id',
				Rule::unique(table: 'clients')
					->where(function (Builder $query): Builder {
						return $query->where([
							'country_id' => $this->country_id,
							'id_type' => $this->id_type,
							'id_number' => $this->id_number,
						]);
				}),
			],
			'id_type' => 'bail|required|string|min:3|max:255',
			'id_number' => 'bail|required|string|min:3|max:255',
			'id_name' => 'bail|required|string|min:3|max:255',
			'gender' => 'bail|required|string|in:Male,Female',
			'dob' => 'bail|required|date_format:Y-m-d',
			'phone' => 'bail|required|string|min:7|max:255',
			'is_handicap' => 'bail|required|boolean',
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
			'country_id.unique' => __('Client already exists (ID type & number in country)'),
		];
	}
}
