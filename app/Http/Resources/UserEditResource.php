<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserEditResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request): array
	{
		return [
			'name' => $this->name,
			'email' => $this->email,
			'contact' => $this->contact,
			'is_active' => $this->is_active,
			'roles' => $request->user()->can('roles') ? $this->roles->pluck('name') : [],
		];
	}
}
