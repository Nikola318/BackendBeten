<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('documents', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->string('path');
			$table->string('model_type');
			$table->unsignedBigInteger('model_id');
			$table->unsignedBigInteger('created_by');
			$table->timestamp('created_at');
			$table->unsignedBigInteger('deleted_by')->nullable();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('documents');
	}
}
