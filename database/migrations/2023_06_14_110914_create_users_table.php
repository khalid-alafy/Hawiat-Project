<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('image')->default('avatar.png');
			$table->string('phone', 10)->unique();
			$table->point('location')->nullable();
            $table->enum('role',['admin','user'])->default('user');
            $table->boolean('suspend')->default('0');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
		});
	}

	public function down()
    {
        Schema::dropIfExists('users');
    }
}
