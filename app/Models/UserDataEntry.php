<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\UserDataEntry
 *
 * @property int $id
 * @property int $user_id
 * @property string $model_type
 * @property int $model_id
 * @property string $method
 * @property string $repository
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataEntry whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataEntry whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataEntry whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataEntry whereRepository($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataEntry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserDataEntry whereUserId($value)
 * @mixin \Eloquent
 */
class UserDataEntry extends Model
{
	use HasFactory;

	protected $table = 'users_dataentry';

	protected $fillable = [
		'user_id',
		'model_type',
		'model_id',
		'method',
		'repository'
	];
}
