<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('vehicles', function (Blueprint $table) {
			$table->id();
			$table->string('model');
			$table->string('manufacturer');
			$table->year('year');
			$table->string('registration');
			$table->integer('badge');
			$table->unsignedInteger('passengers')->nullable();
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('vehicles');
	}
};
