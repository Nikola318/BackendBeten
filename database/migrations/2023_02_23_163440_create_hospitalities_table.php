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
		Schema::create('hospitalities', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->string('description');
			$table->dateTime('required_date');
			$table->float('quantity');
			$table->unsignedBigInteger('received_by');
			$table->text('extra')->nullable();
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
		Schema::dropIfExists('hospitalities');
	}
};
