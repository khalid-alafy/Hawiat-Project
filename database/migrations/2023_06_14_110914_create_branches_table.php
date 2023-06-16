<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBranchesTable extends Migration {

	public function up()
	{
		Schema::create('branches', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->string('location', 255);
			$table->integer('compay_id')->unsigned();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('branches');
	}
}
