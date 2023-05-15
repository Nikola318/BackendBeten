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
		Schema::create('client_logs', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('client_id')
				->comment('related to clients');
			$table->foreign('client_id')
				->references('id')
				->on('clients')
				->onDelete('cascade');
			$table->string('model_type')
				->nullable()
				->comment('meals, vehicles, dormitorios, hospitality');
			$table->unsignedBigInteger('model_id')->nullable();
			$table->string('key')->comment('can duplicate');
			$table->string('value');
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
		Schema::dropIfExists('client_logs');
	}
};
