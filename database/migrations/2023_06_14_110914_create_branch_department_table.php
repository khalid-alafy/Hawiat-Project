<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBranchDepartmentTable extends Migration {

	public function up()
	{
		Schema::create('branch_department', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('branch_id')->unsigned();
			$table->integer('department_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('branch_department');
	}
}