<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Offers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offers', function(Blueprint $table){

            $table->increments('id');
            $table->integer('user_id')->unsigned()->index();
            $table->tinyInteger('type')->index();
            $table->text('description');
            $table->date('date');
            $table->time('time');

            $table->timestamps();

            $table->unique(['user_id','type']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('offers');
	}

}
