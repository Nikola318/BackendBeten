<?php

declare(strict_types=1);

namespace App\Models\Grammar;

use Illuminate\Support\Fluent;
use Illuminate\Database\Schema\Grammars\MySqlGrammar;

/**
 * Extended version of MySQLGrammar with
 * support of 'geometry' data type in MySQL
 */
class ExtendedMySQLGrammar extends MySqlGrammar
{
	/**
	 * Create the column definition for a spatial Geometry type.
	 *
	 * @param \Illuminate\Support\Fluent $column
	 *
	 * @return string
	 */
	public function typeGeometry(Fluent $column)
	{
		return $column->type;
	}
}
