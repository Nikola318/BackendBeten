<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddLogRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		// TODO: also check permission
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
			'service_commit_id' => 'bail|required|integer|exists:service_commits,id',
			'model_type'=> 'bail|required|string',
			'model_id' => 'bail|required|integer',
			'role' => 'bail|required|string|min:3|max:255',
		];
	}
}
