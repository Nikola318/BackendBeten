<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\Document;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class CreateDocumentRequest extends FormRequest
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
		$valid_types = implode(',', Document::$model_types);
		return [
			'model_type' => 'bail|required|string|in:' . $valid_types,
			'model_id' => "bail|required|integer|exists:{$this->table},id",
			'title' => 'bail|required|string|min:5|max:255',
			'documents' => 'bail|required|array',
			'documents.*' => 'bail|required|file|mimes:pdf,png,jpg,jpeg|max:20000',
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
			'documents.*.mimes' => __('File must be either an image or a PDF document'),
			'documents.required' => __('At least one file per document is required'),
		];
	}
}
