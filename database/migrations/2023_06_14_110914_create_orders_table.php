<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->enum('status', array('successful', 'failed', 'pending'));
			$table->double('total_price');
			$table->enum('tenancy', array('contract', 'temporary'));
			$table->integer('user_id')->unsigned();
			$table->integer('product_id')->unsigned();
			$table->integer('payment_id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}