<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('branches', function(Blueprint $table) {
			$table->foreign('compay_id')->references('id')->on('companies')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('departments', function(Blueprint $table) {
			$table->foreign('parent_id')->references('id')->on('departments')
						->onDelete('set null')
						->onUpdate('set null');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->foreign('product_id')->references('id')->on('products')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('products', function(Blueprint $table) {
			$table->foreign('branch_id')->references('id')->on('branches')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('products', function(Blueprint $table) {
			$table->foreign('department_id')->references('id')->on('departments')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('complaints', function(Blueprint $table) {
			$table->foreign('company_id')->references('id')->on('companies')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('complaints', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('rates', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('rates', function(Blueprint $table) {
			$table->foreign('company_id')->references('id')->on('companies')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('reviews', function(Blueprint $table) {
			$table->foreign('company_id')->references('id')->on('companies')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('reviews', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('branch_department', function(Blueprint $table) {
			$table->foreign('branch_id')->references('id')->on('branches')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('branch_department', function(Blueprint $table) {
			$table->foreign('department_id')->references('id')->on('departments')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('branches', function(Blueprint $table) {
			$table->dropForeign('branches_compay_id_foreign');
		});
		Schema::table('departments', function(Blueprint $table) {
			$table->dropForeign('departments_parent_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_user_id_foreign');
		});
		Schema::table('orders', function(Blueprint $table) {
			$table->dropForeign('orders_product_id_foreign');
		});
		Schema::table('products', function(Blueprint $table) {
			$table->dropForeign('products_branch_id_foreign');
		});
		Schema::table('products', function(Blueprint $table) {
			$table->dropForeign('products_department_id_foreign');
		});
		Schema::table('complaints', function(Blueprint $table) {
			$table->dropForeign('complaints_company_id_foreign');
		});
		Schema::table('complaints', function(Blueprint $table) {
			$table->dropForeign('complaints_user_id_foreign');
		});
		Schema::table('rates', function(Blueprint $table) {
			$table->dropForeign('rates_user_id_foreign');
		});
		Schema::table('rates', function(Blueprint $table) {
			$table->dropForeign('rates_company_id_foreign');
		});
		Schema::table('reviews', function(Blueprint $table) {
			$table->dropForeign('reviews_company_id_foreign');
		});
		Schema::table('reviews', function(Blueprint $table) {
			$table->dropForeign('reviews_user_id_foreign');
		});
		Schema::table('branch_department', function(Blueprint $table) {
			$table->dropForeign('branch_department_branch_id_foreign');
		});
		Schema::table('branch_department', function(Blueprint $table) {
			$table->dropForeign('branch_department_department_id_foreign');
		});
	}
}
