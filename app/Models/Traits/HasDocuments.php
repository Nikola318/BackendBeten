<?php

declare(strict_types=1);

namespace App\Models\Traits;

use App\Models\{Client, Crew, User};

trait HasDocuments
{
	/**
	 * The "boot" method of the model.
	 *
	 * @return void
	 */
	protected static function bootHasDocuments(): void
	{
		// Unset the globally appended is_documentable when saving
		// Because it's a runtime property and not a database column
		static::saving(function ($model) {
			unset($model->is_documentable);
		});

		// Any model that uses this trait should append a property called
		// is_documentable with a value of true
		static::retrieved(function ($model) {
			if (request()->user()) {
				if (
					($model instanceof User &&
						!request()->user()->can('users.documents.view')) ||
					($model instanceof Crew &&
						!request()->user()->can('crews.documents.view')) ||
					($model instanceof Client &&
						!request()->user()->can('clients.documents.view'))
				) {
					$model->is_documentable = false;
				} else {
					$model->is_documentable = true;
				}
			}
		});
	}
}
