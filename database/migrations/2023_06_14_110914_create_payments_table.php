<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {

	public function up()
	{
		Schema::create('payments', function(Blueprint $table) {
			$table->increments('id');
			$table->enum('type', array('paytab', 'paypal','stribe'));
			$table->enum('status', array('successful', 'failed', 'pending'));
			$table->string('transaction_code', 255)->unique();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('payments');
	}
}
