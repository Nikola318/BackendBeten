<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class DocumentResource extends JsonResource
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
			'title' => $this->title,
			'path' => Storage::url($this->path),
			'model_type' => $this->model_type,
			'model_id' => $this->model_id,
			'created_by' => $this->creator->name,
			'created_at' => $this->created_at,
			'deleted_by' => $this->deleted_by,
			'deleted_at' => $this->deleted_at,
		];
	}
}
