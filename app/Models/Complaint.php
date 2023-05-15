<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\HasDocuments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\Complaint
 *
 * @property int $id
 * @property string $title
 * @property string|null $referfence
 * @property string|null $commenter_model_type
 * @property int|null $commenter_model_id
 * @property string $upon_model_type
 * @property int $upon_model_id
 * @property string $comment
 * @property int $created_by user_id
 * @property int|null $closed_by user_id
 * @property string|null $closed_at
 * @property string|null $closed_comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint query()
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereClosedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereClosedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereClosedComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereCommenterModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereCommenterModelType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereReferfence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereUponModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereUponModelType($value)
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property-read int|null $documents_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Document> $documents
 * @property string|null $reference
 * @property string $location
 * @method static \Database\Factories\ComplaintFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Complaint whereReference($value)
 * @mixin \Eloquent
 */
class Complaint extends Model
{
	use HasDocuments, HasFactory;

	protected $table = 'complaints';
}
