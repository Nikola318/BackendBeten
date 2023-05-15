<?php

declare(strict_types=1);

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\{HasContracts, HasDocuments};
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Dormitory
 *
 * @property int $id
 * @property string $title
 * @property string $phones
 * @property int $city_id
 * @property string $location
 * @property mixed|null $coordinate json of geometry
 * @property int $is_active
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\DormitoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Dormitory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dormitory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Dormitory query()
 * @method static \Illuminate\Database\Eloquent\Builder|Dormitory whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dormitory whereCoordinate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dormitory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dormitory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dormitory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dormitory whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dormitory whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dormitory wherePhones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dormitory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Dormitory whereUpdatedAt($value)
 * @property-read \App\Models\City $city
 * @mixin \Eloquent
 */
class Dormitory extends Model
{
	use HasContracts, HasDocuments, HasFactory;

	/**
	 * The single value that should be used to represent the model when being displayed.
	 *
	 * @var string
	 */
	public static string $title = 'title';

	/**
	 * The attributes that should be cast.
	 *
	 * @var array
	 */
	protected $casts = [
		'is_active' => 'boolean',
	];

	/**
	 * Get the city in which this dormitory resides
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 **/
	public function city(): BelongsTo
	{
		return $this->belongsTo(related: City::class);
	}

	/**
	 * Prepare a date for array / JSON serialization.
	 */
	protected function serializeDate(DateTimeInterface $date): string
	{
		return $date->format('Y-m-d H:i:s');
	}
}
