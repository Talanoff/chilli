<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacteristicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characteristics', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', array_keys(\App\Models\Product\Characteristic::$TYPES))->default('text');
            $table->string('value');
            $table->unsignedInteger('type_id');
			$table->string('1c_id')->nullable();
            $table->timestamps();

            $table->foreign('type_id')
                  ->references('id')->on('characteristic_types')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characteristics');
    }
}
