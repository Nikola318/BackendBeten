<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Models\ServiceCommit;
use Illuminate\Foundation\Http\FormRequest;

class ReleaseServiceCommitRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		$owner_id = ServiceCommit::select('supervisor_id')
			->where('id', $this->id)
			->first()
			->value('supervisor_id');
		return auth()->check() && (
			$this->user()->can('service_commits.release') ||
			$this->user()->id === $owner_id
		);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules(): array
	{
		return [
			'id' => [
				'bail',
				'required',
				'integer',
				'exists:service_commits,id',
				function ($attribute, $value, $fail) {
					if (ServiceCommit::where('id', $value)
						// Must validate service commit has a starting date
						->whereNull('started_at')
						->exists()) {
							$fail(__('Service commit hasn\'t started'));
						}
				}
			],
		];
	}
}
