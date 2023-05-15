<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * App\Models\InvoiceRow
 *
 * @property-read \App\Models\Invoice|null $invoice
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceRow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceRow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InvoiceRow query()
 * @mixin \Eloquent
 */
class InvoiceRow extends Model
{
	use HasFactory;

	public function invoice(){
		return $this->belongsTo(Invoice::class);
	}
}
