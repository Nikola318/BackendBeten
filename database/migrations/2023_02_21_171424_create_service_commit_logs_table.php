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
	public function up()
	{
		Schema::create('service_commit_logs', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('service_commit_id');
			$table->string('model_type');
			$table->unsignedBigInteger('model_id');
			$table->string('role');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('service_commit_logs');
	}
};
