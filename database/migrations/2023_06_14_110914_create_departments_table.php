<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepartmentsTable extends Migration {

	public function up()
	{
		Schema::create('departments', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->enum('tenancy_type', array(0,1,2));
			// 0 => contract, 1 =>temporary, 2 => both
			$table->integer('parent_id')->unsigned()->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('departments');
	}
}