<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Contract;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class CreateContractRequest extends FormRequest
{
	/** @var string $table Database table to check type ID existence in */
	private string $table = '';

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		// TODO: validate permission as well
		return auth()->check();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules(): array
	{
		$valid_types = implode(',', Contract::$model_types);
		return [
			'model_type' => 'bail|required|string|in:' . $valid_types,
			'model_id' => "bail|required|integer|exists:{$this->table},id",
			'reference' => 'bail|required|string|min:5|max:255',
			'contracts' => 'bail|required|array',
			'contracts.*' => 'bail|required|file|mimes:pdf,png,jpg,jpeg|max:20000',
		];
	}

	/**
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation(): void
	{
		if ($this->type) {
			$this->merge([
				'model_type' => 'App\Models\\' . Str::title($this->type),
			]);
			// TODO: check guarantee, table name could differ from the model?
			// In that case, probably best to init an object and get table prop
			$this->table = Str::plural($this->type);
		}
		if ($this->id) {
			$this->merge([
				'model_id' => (int) $this->id,
			]);
		}
	}

	/**
	 * Get custom messages for validator errors.
	 *
	 * @return array
	 */
	public function messages(): array
	{
		return [
			'contracts.*.mimes' => __('File must be either an image or a PDF document'),
			'contracts.required' => __('At least one file per contract is required'),
		];
	}
}
