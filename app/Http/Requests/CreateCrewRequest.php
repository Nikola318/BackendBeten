<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;

class CreateCrewRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		return auth()->check() && $this->user()->can('crews.create');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules(): array
	{
		return [
			'fullname' => 'bail|required|string|min:3|max:255',
			'gender' => 'bail|required|string|in:Male,Female',
			'profession_id' => 'bail|nullable|integer|exists:professions,id',
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
			'phone' => 'bail|nullable|string|min:3|max:255',
			'id_type' => 'bail|required|string|min:3|max:255',
			'id_name' => 'bail|required|string|min:3|max:255',
			'id_number' => 'bail|required|string|min:3|max:255',
			'dob' => 'bail|nullable|date_format:Y-m-d',
			'is_active' => 'bail|required|boolean',
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
			'country_id.unique' => __('Crew member already exists (ID type & number in country)'),
		];
	}
}
