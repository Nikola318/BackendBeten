<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('meals', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('meal_type_id');
			$table->foreign('meal_type_id')->references('id')->on('meal_types');
			$table->unsignedInteger('quantity');
			$table->string('to_model_type');
			$table->unsignedBigInteger('to_model_id');
			$table->dateTime('sent_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('meals');
	}
};
