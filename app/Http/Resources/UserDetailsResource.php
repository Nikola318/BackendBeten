<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserDetailsResource extends JsonResource
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
			'id' => $this->id,
			'name' => $this->name,
			'email' => $this->email,
			'is_active' => $this->is_active,
			'contact' => $this->contact,
			// Roles is a collection
			// @see https://laravel.com/docs/9.x/collections#method-implode
			'roles' => $this->roles->implode('name', ', '),
			'is_documentable' => $this->is_documentable,
			'is_contractable' => $this->is_contractable,
		];
	}
}
