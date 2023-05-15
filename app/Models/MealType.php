<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\MealType
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $has_documents
 * @method static \Database\Factories\MealTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|MealType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MealType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MealType query()
 * @method static \Illuminate\Database\Eloquent\Builder|MealType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MealType whereHasDocuments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MealType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|MealType whereTitle($value)
 * @mixin \Eloquent
 */
class MealType extends Model
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
}
