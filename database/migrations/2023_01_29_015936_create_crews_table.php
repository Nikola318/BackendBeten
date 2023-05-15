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
		Schema::create('crews', function (Blueprint $table) {
			$table->id();
			$table->unsignedBigInteger('user_id')->nullable();
			$table->foreign('user_id')->references('id')->on('users')
				->onDelete('cascade');
			$table->string('fullname')->comment('Name in Arabic language');
			$table->enum('gender', [
				'Male',
				'Female',
			])->default('Male');
			$table->unsignedBigInteger('profession_id')->nullable();
			$table->foreign('profession_id')->references('id')
				->on('professions')
				->onDelete('cascade');
			$table->unsignedBigInteger('country_id');
			$table->foreign('country_id')->references('id')->on('countries');
			$table->string('phone')->nullable();
			$table->string('id_type');
			$table->string('id_name');
			$table->string('id_number');
			$table->date('dob')->nullable();
			$table->boolean('is_active')->default(true);
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
		Schema::dropIfExists('crews');
	}
};
