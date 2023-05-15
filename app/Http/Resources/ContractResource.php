<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContractResource extends JsonResource
{
	/**
	 * Transform the contract into an array.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return array
	 */
	public function toArray($request): array
	{
		return [
			'id' => $this->id,
			'reference' => $this->reference,
			'model_type' => $this->model_type,
			'model_id' => $this->model_id,
			'extra' => $this->extra,
			'created_by' => $this->created_by,
			'created_at' => $this->created_at,
			'deleted_by' => $this->deleted_by,
			'deleted_at' => $this->deleted_at,
		];
	}
}
