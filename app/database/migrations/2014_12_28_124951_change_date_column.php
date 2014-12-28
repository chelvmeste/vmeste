<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDateColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::statement('ALTER TABLE `offers` MODIFY `date` DATE NULL;');
		DB::statement('ALTER TABLE `offers` MODIFY `time` TIME NULL;');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::statement('ALTER TABLE `offers` MODIFY `date` DATE NOT NULL;');
		DB::statement('ALTER TABLE `offers` MODIFY `time` TIME NOT NULL;');
	}

}
