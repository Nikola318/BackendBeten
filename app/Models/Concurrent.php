<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Concurrent
 *
 * @property int $id
 * @property string $starting_at
 * @property string $ending_at
 * @property string $model_type
 * @property int $model_id
 * @property string|null $repeated_every day, week
 * @property array $extra JSON of what data to be feeded to model, NOT VERY CLEAR
 * @method static \Database\Factories\ConcurrentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Concurrent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Concurrent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Concurrent query()
 * @method static \Illuminate\Database\Eloquent\Builder|Concurrent whereEndingAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Concurrent whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Concurrent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Concurrent whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Concurrent whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Concurrent whereRepeatedEvery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Concurrent whereStartingAt($value)
 * @mixin \Eloquent
 */
class Concurrent extends Model
{
	use HasFactory;

	/**
	 * The table associated with the model.
	 *
	 * @var string
	 */
	protected $table = 'concurrent';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
		'extra' => 'json',
	];

	/** @var array $model_types Available model types for concurrents */
	// This property is used for validation ATM
	// Not a constant because client said so
	public static array $model_types = [
		ServiceCommit::class,
	];
}
