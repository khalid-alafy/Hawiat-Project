<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	public function up()
	{
		Schema::create('products', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->string('image', 255)->nullable()->default('avatar.png');
			$table->double('price');
			$table->string('volume', 255);
			$table->text('description')->nullable();
			$table->enum('tenancy_type', array('contract', 'temporary'));
			$table->integer('branch_id')->unsigned();
			$table->integer('department_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('products');
	}
}