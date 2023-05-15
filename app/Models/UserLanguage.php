<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\UserLanguage
 *
 * @property int $user_id
 * @property int $language_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Language> $language
 * @property-read int|null $language_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserLanguage whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserLanguage whereUserId($value)
 * @mixin \Eloquent
 */
class UserLanguage extends Model
{
	use HasFactory;

	protected $table = 'user_languages';

	protected $fillable = [
		'user_id',
		'language_id',
	];

	public function user()
	{
		return $this->belongsTo(User::class, 'id', 'user_id');
	}
	public function language()
	{
		return $this->hasMany(Language::class, 'id', 'language_id');
	}
}
