<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MealResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return array
	 */
	public function toArray($request): array
	{
		return [
			'id' => $this->id,
			'type' => $this->mealType->title,
			'quantity' => $this->quantity,
			'sent_at' => $this->sent_at,
		];
	}
}
