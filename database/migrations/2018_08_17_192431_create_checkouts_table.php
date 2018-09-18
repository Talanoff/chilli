<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->increments('id');

            $table->enum('status', array_keys(App\Models\Order\Checkout::$STATUSES))
                  ->default(array_keys(App\Models\Order\Checkout::$STATUSES)[0]);

            $table->string('user_id');
            $table->unsignedInteger('product_id')->nullable();
            $table->unsignedInteger('kit_id')->nullable();
            $table->unsignedInteger('order_id')->nullable();

            $table->unsignedInteger('quantity');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('checkouts');
    }
}
