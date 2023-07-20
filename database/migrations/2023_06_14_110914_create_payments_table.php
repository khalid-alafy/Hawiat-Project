<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePaymentsTable extends Migration {

	public function up()
	{
        //The respCode, respStatus, and respMessage
		Schema::create('payments', function(Blueprint $table) {
			$table->increments('id');
            $table->enum('payment_status', array('success', 'failed', 'pending'));
            $table->text('payment_response')->nullable(); // Store the complete PayTabs payment response JSON for reference
            $table->string('tran_ref')->unique();
			$table->timestamps();
			$table->integer('user_id')->unsigned(); // If you have user authentication and want to associate payments with users
			$table->integer('order_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('payments');
	}
}
