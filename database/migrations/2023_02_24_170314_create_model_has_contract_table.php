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
		Schema::create('model_has_contract', function (Blueprint $table) {
			$table->unsignedBigInteger('contract_id');
			$table->foreign('contract_id')->references('id')->on('contracts')
				->onDelete('cascade');
			$table->primary(
				['contract_id', 'model_id', 'model_type'],
				'model_has_contract_contract_model_type_primary'
			);
			$table->string('model_type');
			$table->unsignedBigInteger('model_id');
			$table->index(
				['model_id', 'model_type'],
				'model_has_contract_model_id_model_type_index'
			);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('model_has_contract');
	}
};
