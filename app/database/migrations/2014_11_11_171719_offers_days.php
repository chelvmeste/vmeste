<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OffersDays extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offer_days', function(Blueprint $table) {

            $table->increments('id');
            $table->integer('offer_id')->unsigned()->index();
            $table->integer('day');
            $table->time('time_start');
            $table->time('time_end');
            $table->timestamps();

            $table->unique(['offer_id', 'day']);

            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('offer_days');
	}

}
