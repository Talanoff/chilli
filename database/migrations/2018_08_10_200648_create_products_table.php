<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');

            $table->string('slug')->unique();
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('brand_id')->nullable();

            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->mediumText('description')->nullable();

            $table->float('rating')->nullable();
            $table->string('tag')->nullable();

            $table->float('price');
            $table->float('discount')->nullable();
            $table->unsignedInteger('quantity')->nullable();

            $table->boolean('in_stock')->default(0);
            $table->boolean('is_published')->default(0);

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
        Schema::dropIfExists('products');
    }
}
