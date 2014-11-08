<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OfferResponses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('offers_responses', function(Blueprint $table) {

            $table->increments('id');
            $table->integer('offer_id')->unsigned()->index();
            $table->integer('offer_user_id')->unsigned()->index();
            $table->integer('request_id')->unsigned()->index();
            $table->integer('request_user_id')->unsigned()->index();
            $table->integer('initiator_user_id')->unsigned()->index();
            $table->text('offer_response');
            $table->text('request_response');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('offer_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('request_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->foreign('request_id')->references('id')->on('offers')->onDelete('cascade');

        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('offers_responses');
	}

}
