<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;
use App\Rules\ClientGroupUnassigned;
use Illuminate\Foundation\Http\FormRequest;

class AddClientsToGroupRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize(): bool
	{
		$user_id = DB::table('crews')
			->leftJoin('groups', 'groups.crew_id', 'crews.id')
			->select('crews.user_id')
			->where('groups.id', $this->group_id)
			->value('user_id');

		return auth()->check() && (
			$this->user()->can('groups.clients.add') ||
			// If the currently authenticated user is the crew member leading
			// this group
			$this->user()->id === $user_id
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
			'group_id' => 'bail|required|integer|exists:groups,id',
			'clients' => 'bail|required|array',
			'clients.*' => [
				'bail',
				'required',
				'integer',
				'exists:clients,id',
				// validate client is not already in another group
				new ClientGroupUnassigned
			],
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
			'group_id.exists' => __('Selected group does not exist'),
		];
	}
}
