<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('user_id');
            $table->enum('status', array_keys(App\Models\Order\Order::$STATUSES))
                  ->default(array_keys(App\Models\Order\Order::$STATUSES)[0]);

            $table->enum('delivery', array_keys(App\Models\Order\Order::$DELIVERY))
                  ->default(array_keys(App\Models\Order\Order::$DELIVERY)[0]);
            $table->string('city')->nullable();
            $table->string('warehouse')->nullable();
            $table->string('address')->nullable();

            $table->text('message')->nullable();

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
        Schema::dropIfExists('orders');
    }
}
