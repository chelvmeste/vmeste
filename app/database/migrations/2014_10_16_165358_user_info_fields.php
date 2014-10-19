<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserInfoFields extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('users',function(Blueprint $table){

            $table->enum('gender', array('male', 'female'))->after('last_name');
            $table->date('birthdate')->after('gender');
            $table->string('vk_id')->after('birthdate');
            $table->integer('phone')->after('vk_id');
            $table->string('address')->after('phone');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table){

            $table->dropColumn(array(
                'gender',
                'birthdate',
                'vk_id',
                'phone',
                'address',
            ));

        });
	}

}
