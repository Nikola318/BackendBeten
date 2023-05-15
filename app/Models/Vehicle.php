<?php

declare(strict_types=1);

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\{HasContracts, HasDocuments};
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Vehicle
 *
 * @property int $id
 * @property string $model
 * @property string $manufacturer
 * @property string $year
 * @property string $registration
 * @property int $badge
 * @property int|null $passengers
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\VehicleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle query()
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereBadge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereManufacturer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle wherePassengers($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereRegistration($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Vehicle whereYear($value)
 * @mixin \Eloquent
 */
class Vehicle extends Model
{
	use HasContracts, HasDocuments, HasFactory;

	/**
	 * The single value that should be used to represent the model when being displayed.
	 *
	 * @var string
	 */
	public static string $title = 'model';

	/**
	 * Prepare a date for array / JSON serialization.
	 *
	 * @return string date formatted
	 */
	protected function serializeDate(DateTimeInterface $date): string
	{
		return $date->format('Y-m-d H:i:s');
	}
}
