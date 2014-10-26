<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAddressCoords extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users',function(Blueprint $table) {

            $table->decimal('address_longitude',10,8)->after('address')->nullable()->default(NULL);
            $table->decimal('address_latitude',11,8)->after('address_longitude')->nullable()->default(NULL);

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('users',function(Blueprint $table) {

            $table->dropColumn(['address_longitude','address_latitude']);

        });
	}

}
