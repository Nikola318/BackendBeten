<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Support\Str;
use App\Models\{Concurrent, ServiceCommit};
use Illuminate\Foundation\Http\FormRequest;

class CreateConcurrentRequest extends FormRequest
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
		$supervisor = null;
		if ($this->model_type === ServiceCommit::class) {
			$supervisor = ServiceCommit::select('supervisor_id')
				->where('id', $this->model_id)
				->value('supervisor_id');
		}
		return auth()->check() && ($this->user()->can($this->table . '.concurrents.create') ||
			$this->user()->id === $supervisor
		);
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules(): array
	{
		$valid_types = implode(',', Concurrent::$model_types);
		return [
			'model_type' => 'bail|required|string|in:' . $valid_types,
			'model_id' => "bail|required|integer|exists:{$this->table},id",
			'starting_at' => 'bail|required|date_format:Y-m-d H:i:s',
			'ending_at' => 'bail|required|date_format:Y-m-d H:i:s',
			'extra' => 'bail|required',
			'extra.frequency' => 'bail|required|string|in:daily,weekly',
			'extra.alerts' => 'bail|required|array',
			'extra.alerts.*.window' => [
				'bail',
				'required_if:extra.frequency,daily',
				'integer',
				'min:10',
				'max:60',
			],
			'extra.alerts.*.time' => [
				'bail',
				'required_if:extra.frequency,daily',
				'date_format:H:i',
			],
			'extra.alerts.*.notificants' => 'bail|required',
			'extra.alerts.*.notificants.roles' => [
				'bail',
				'required_without:extra.alerts.*.notificants.users',
				'array',
			],
			'extra.alerts.*.notificants.roles.*' => [
				'bail',
				'required_with:extra.alerts.*.notificants.roles',
				'integer',
				'exists:roles,id',
			],
			'extra.alerts.*.notificants.users' => [
				'bail',
				'required_without:extra.alerts.*.notificants.roles',
				'array',
			],
			'extra.alerts.*.notificants.users.*' => [
				'bail',
				'required_with:extra.alerts.*.notificants.users',
				'integer',
				'exists:users,id',
			],
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
			$model = 'App\Models\\' . Str::title($this->type);
			if ($model == 'App\Models\Servicecommit') {
				$model = ServiceCommit::class;
			}
			$this->merge([
				'model_type' => $model,
			]);
			$this->table = (new $model)->getTable();
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
			'extra.frequency.in' => __('Concurrent frequency can only be either daily or weekly.'),
			'extra.alerts.required' => __('Must set at least one concurrent.'),
			'extra.alerts.*.time.date_format' => __('Concurrent time must be in hours:minutes format.')
		];
	}
}
