<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCompaniesTable extends Migration {

	public function up()
	{
		Schema::create('companies', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name', 255);
			$table->string('owner_name', 255);
			$table->string('email', 255)->unique();
			$table->string('commercial_register', 10)->unique();
			$table->string('phone', 10)->unique();
			$table->string('password', 255);
			$table->string('tax_record', 11)->unique();
			$table->string('city', 100);
			$table->point('location')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('companies');
	}
}