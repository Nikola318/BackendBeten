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
		Schema::create('concurrent', function (Blueprint $table) {
			$table->id();
			$table->dateTime('starting_at');
			$table->dateTime('ending_at');
			$table->string('model_type');
			$table->unsignedBigInteger('model_id');
			$table->string('repeated_every')->nullable()->comment('day, week');
			$table->json('extra')->comment('JSON of what data to be feeded to model, NOT VERY CLEAR');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('concurrent');
	}
};
