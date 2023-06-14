<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRatesTable extends Migration {

	public function up()
	{
		Schema::create('rates', function(Blueprint $table) {
			$table->increments('id');
			$table->enum('rate', array('1', '2', '3', '4', '5'));
			$table->integer('user_id')->unsigned();
			$table->integer('company_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('rates');
	}
}