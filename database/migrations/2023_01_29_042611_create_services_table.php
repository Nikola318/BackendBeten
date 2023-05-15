<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('services', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->unsignedBigInteger('city_id');
			$table->dateTime('before_date')->nullable();
			$table->dateTime('exact_date')->nullable();
			$table->dateTime('after_date')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('services');
	}
}
