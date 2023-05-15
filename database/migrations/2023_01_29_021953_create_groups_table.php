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
		Schema::create('groups', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->unsignedBigInteger('crew_id');
			$table->foreign('crew_id')->references('id')->on('crews')
				->onDelete('cascade');
			$table->unsignedInteger('clients_virtual_count')->nullable()
				->comment('it doesnt preset real clients');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('groups');
	}
};
