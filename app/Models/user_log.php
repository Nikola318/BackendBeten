<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\user_log
 *
 * @property int $id
 * @property int $user_id
 * @property string $model_type
 * @property int $model_id
 * @property string $method
 * @property string $repository
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|user_log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|user_log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|user_log query()
 * @method static \Illuminate\Database\Eloquent\Builder|user_log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|user_log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|user_log whereMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|user_log whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|user_log whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|user_log whereRepository($value)
 * @method static \Illuminate\Database\Eloquent\Builder|user_log whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|user_log whereUserId($value)
 * @mixin \Eloquent
 */
class user_log extends Model
{
	use HasFactory;
}
