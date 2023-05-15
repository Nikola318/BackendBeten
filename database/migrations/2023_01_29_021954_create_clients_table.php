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
		Schema::create('clients', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('group_id')->nullable();
			$table->foreign('group_id')
				->references('id')
				->on('groups')
				->onDelete('set null');
			$table->string('fullname')->comment('Arabic language');
			$table->unsignedBigInteger('country_id');
			$table->string('id_type');
			$table->string('id_number');
			$table->string('id_name');
			$table->enum('gender', [
				'Male',
				'Female',
			])->default('Male');
			$table->date('dob');
			$table->string('phone');
			$table->boolean('is_handicap')->default(false);
			$table->timestamps();
			$table->softDeletes();
			$table->unique(['country_id', 'id_type', 'id_number']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::dropIfExists('clients');
	}
};
