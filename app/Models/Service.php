<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Service
 *
 * @property int $id
 * @property string $title
 * @property int $city_id
 * @property \Illuminate\Support\Carbon|null $before_date
 * @property \Illuminate\Support\Carbon|null $exact_date
 * @property \Illuminate\Support\Carbon|null $after_date
 * @property-read \App\Models\City|null $city
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Phase> $phases
 * @property-read int|null $phases_count
 * @method static \Database\Factories\ServiceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Service newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereAfterDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereBeforeDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereExactDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service whereTitle($value)
 * @mixin \Eloquent
 */
class Service extends Model
{
	use HasFactory;

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
		'before_date' => 'date:Y-m-d',
		'exact_date' => 'date:Y-m-d',
		'after_date' => 'date:Y-m-d',
	];

	public function city()
	{
		return $this->belongsTo(City::class, 'city_id');
	}

	/**
	 * The phases that belong to the service.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function phases(): BelongsToMany
	{
		return $this->belongsToMany(related: Phase::class);
	}
}
