<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model, SoftDeletes};

/**
 * App\Models\Document
 *
 * @property int $id
 * @property string $title
 * @property string $path
 * @property string $model_type
 * @property int $model_id
 * @property int $created_by
 * @property \Illuminate\Support\Carbon $created_at
 * @property int|null $deleted_by
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $document_type
 * @property string|null $description
 * @property int|null $uploaded_by
 * @property-read \App\Models\User|null $creator
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDeletedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDocumentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUploadedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Document withoutTrashed()
 * @mixin \Eloquent
 */
class Document extends Model
{
	use HasFactory, SoftDeletes;

	/**
	 * The name of the "updated at" column.
	 *
	 * @var string|null
	 */
	const UPDATED_AT = null;

	/** @var array $model_types Available model types for contracts */
	// Note that this property is currently for documentation purposes only
	// It's not referenced or used anywhere in the codebase
	public static array $model_types = [
		// other than contract, for example location, terms, photos..etc
		Client::class,
		Complaint::class,
		Contract::class,
		Crew::class,
		Dormitory::class,
		User::class,
		Vehicle::class,
		Group::class
	];

	/**
	 * Get the user who created the document.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function creator(): BelongsTo
	{
		return $this->belongsTo(related: User::class, foreignKey: 'created_by');
	}
}
