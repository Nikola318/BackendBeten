<?php

declare(strict_types=1);

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Hospitality
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon $required_date
 * @property int $quantity
 * @property int $received_by
 * @property string|null $extra
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Crew $receiver
 * @method static \Illuminate\Database\Eloquent\Builder|Hospitality newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hospitality newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Hospitality query()
 * @method static \Illuminate\Database\Eloquent\Builder|Hospitality whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hospitality whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hospitality whereExtra($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hospitality whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hospitality whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hospitality whereReceivedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hospitality whereRequiredDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hospitality whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Hospitality whereUpdatedAt($value)
 * @method static \Database\Factories\HospitalityFactory factory($count = null, $state = [])
 * @mixin \Eloquent
 */
class Hospitality extends Model
{
	use HasFactory;

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
		'required_date' => 'datetime',
	];

	/**
	 * Prepare a date for array / JSON serialization.
	 *
	 * @return string the date formatted
	 */
	protected function serializeDate(DateTimeInterface $date): string
	{
		return $date->format('Y-m-d');
	}

	/**
	 * Get the crew member receiving the hospitality
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	 public function receiver(): BelongsTo
	 {
		return $this->belongsTo(Crew::class, 'received_by');
	 }
}
