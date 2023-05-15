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
		Schema::create('phase_service', function (Blueprint $table) {
			$table->unsignedBigInteger('phase_id');
			$table->foreign('phase_id')->references('id')->on('phases')
				->onDelete('cascade');
			$table->unsignedBigInteger('service_id');
			$table->foreign('service_id')->references('id')->on('services')
				->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('phase_service');
	}
};
