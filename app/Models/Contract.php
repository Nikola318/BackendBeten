<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasDocuments;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

/**
 * App\Models\Contract
 *
 * @property int $id
 * @property string $url
 * @property int $contractable_id
 * @property string $contractable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property-read int|null $documents_count
 * @method static \Illuminate\Database\Eloquent\Builder|Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract query()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereContractableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereContractableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereUrl($value)
 * @property string $reference
 * @property string $model_type
 * @property int $model_id
 * @property mixed|null $extra
 * @property int $created_by
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @method static \Illuminate\Database\Eloquent\Builder|Contract onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Contract withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Contract withoutTrashed()
 * @mixin \Eloquent
 */
class Contract extends Model
{
	/**
	 * A contract is an arbitrary record in the database
	 * i.e it does not hold actual files
	 * We create multiple documents that do, belonging to the contract
	 * But the document record itself belong to the model type coming
	 * from the request, this explains why Contract model uses the trait
	 * HasDocuments
	 */
	use HasDocuments, SoftDeletes;

	/**
	 * The name of the "updated at" column.
	 *
	 * @var string|null
	 */
	const UPDATED_AT = null;

	/** @var array $model_types Available model types for contracts */
	// This property is used for validation ATM
	public static array $model_types = [
		Crew::class,
		Vehicle::class,
		Dormitory::class,
	];

	// TODO: cast extra JSON column into an array if we end up adding it

	/**
	 * Get the documents belonging to the model.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function documents(): MorphMany
	{
		// the name is weird right? it should be documentable
		// But the client required that name in DB schema
		return $this->morphMany(related: Document::class, name: 'model');
	}
}
