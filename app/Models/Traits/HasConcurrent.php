<?php

declare(strict_types=1);

namespace App\Models\Traits;

trait HasConcurrent
{
	/**
	 * The "boot" method of the model.
	 *
	 * @return void
	 */
	protected static function bootHasConcurrent(): void
	{
		// Unset the globally appended is_concurrable when saving
		// Because it's a runtime property and not a database column
		static::saving(function ($model) {
			unset($model->is_concurrable);
		});

		// Any model that uses this trait should append a property called
		// is_concurrable with a value of true
		static::retrieved(function ($model) {
			$model->is_concurrable = true;
		});
	}
}
