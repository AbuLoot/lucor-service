<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlideTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('slide', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->enum('direction', ['left', 'center', 'right']);
            $table->string('color');
            $table->string('slug');
            $table->string('title');
            $table->string('image');
            $table->string('link');
            $table->string('marketing');
            $table->char('lang', 4);
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('slide');
    }
}
