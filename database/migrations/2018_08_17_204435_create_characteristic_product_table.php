<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacteristicProductTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('characteristic_product', function (Blueprint $table) {
			$table->unsignedInteger('characteristic_id');
			$table->unsignedInteger('product_id');
			$table->string('1c_id')->nullable();

			$table->foreign('characteristic_id')->references('id')->on('characteristics')->onDelete('cascade');
			$table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('characteristic_product');
	}
}
