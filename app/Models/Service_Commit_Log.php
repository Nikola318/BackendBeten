<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Service_Commit_Log
 *
 * @property int $id
 * @property int $service_commit_id
 * @property string $model_type
 * @property int $model_id
 * @property string $roles
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Service_Commit_Log newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service_Commit_Log newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Service_Commit_Log query()
 * @method static \Illuminate\Database\Eloquent\Builder|Service_Commit_Log whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service_Commit_Log whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service_Commit_Log whereModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service_Commit_Log whereModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service_Commit_Log whereRoles($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service_Commit_Log whereServiceCommitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Service_Commit_Log whereUpdatedAt($value)
 * @property string $role
 * @method static \Illuminate\Database\Eloquent\Builder|Service_Commit_Log whereRole($value)
 * @mixin \Eloquent
 */
class Service_Commit_Log extends Model
{
	use HasFactory;

	protected $table = 'service_commit_logs';

	protected $fillable = [
		'service_commit_id',
		'model_type',
		'model_id',
		'role',
		'created_at',
		'updated_at',
	];

	/**
	 * The accessors to append to the model's array form.
	 *
	 * @var array
	 */
	protected $appends = ['title', 'name'];

	/**
	 * Determine if the user is an administrator.
	 *
	 * @return \Illuminate\Database\Eloquent\Casts\Attribute
	 */
	protected function title(): Attribute
	{
		return new Attribute(
			get: fn () => __($this->model_type),
		);
	}

	/**
	 * Get the model name (title).
	 *
	 * Retreive the related model record's title based on the model type and ID
	 *
	 * @return \Illuminate\Database\Eloquent\Casts\Attribute
	 */
	protected function name(): Attribute
	{
		return new Attribute(
			get: fn () => $this->model_type::select($this->model_type::$title)
				->where('id', $this->model_id)
				->value($this->model_type::$title),
		);
	}
}
