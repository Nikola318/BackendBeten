<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\ClientLanguage
 *
 * @property int $client_id
 * @property int $language_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Language> $language
 * @property-read int|null $language_count
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLanguage whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ClientLanguage whereLanguageId($value)
 * @mixin \Eloquent
 */
class ClientLanguage extends Model
{
	use HasFactory;

	/**
	 * Get the languages that the client understands???
	 * TODO: figure this out
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function language(): HasMany
	{
		return $this->hasMany(
			related: Language::class,
			foreignKey: 'id',
			localKey: 'language_id'
		);
	}
}
