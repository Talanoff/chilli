<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->increments('id');

            $table->string('slug');
            $table->enum('type', array_keys(App\Models\Review\Review::$CATEGORIES))
                ->default(array_keys(App\Models\Review\Review::$CATEGORIES)[0]);

            $table->string('title');
            $table->mediumText('description')->nullable();
            $table->string('video_url')->nullable();

            $table->unsignedInteger('product_id')->nullable();

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
        Schema::dropIfExists('reviews');
    }
}
