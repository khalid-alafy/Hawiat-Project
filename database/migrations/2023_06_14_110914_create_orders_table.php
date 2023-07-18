<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
            $table->increments('id');
            $table->double('total_price');
            $table->integer('quantity');
            $table->string('currency');
            $table->enum('tenancy', array('contract', 'temporary'));
			$table->integer('user_id')->unsigned();
			$table->integer('product_id')->unsigned();//must have an OrderProduct table if we need to order more than one Product
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
