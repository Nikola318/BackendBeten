<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

/**
 * App\Models\Group
 *
 * @property int $id
 * @property string $title
 * @property int $crew_id
 * @property int|null $clients_virtual_count it doesnt preset real clients
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \App\Models\Crew $crew
 * @method static \Database\Factories\GroupFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Group newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Group query()
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereClientsVirtualCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereCrewId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Group whereTitle($value)
 * @mixin \Eloquent
 */
class Group extends Model
{
	use HasFactory;

	/**
	 * The single value that should be used to represent the model when being displayed.
	 *
	 * @var string
	 */
	public static string $title = 'title';

	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	/**
	 * Get the crew member of this group.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function crew(): BelongsTo
	{
		return $this->belongsTo(related: Crew::class);
	}

	/**
	 * Get the clients in this group.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function clients(): HasMany
	{
		return $this->hasMany(related: Client::class);
	}
}
