<?php

declare(strict_types=1);

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ClientLog
 *
 * @property int $id
 * @property int $client_id related to clients
 * @property string|null $model_type meals, vehicles, dormitorios, hospitality
 * @property int|null $model_id
 * @property string $key can duplicate
 * @property string $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLog whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLog whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLog whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLog whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLog whereValue($value)
 * @mixin \Eloquent
 */
class ClientLog extends Model
{
	use HasFactory;

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
