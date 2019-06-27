<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id')->nullable();
            $table->integer('page_id')->references('id')->on('users')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->string('headline');
            $table->string('video')->nullable();
            $table->string('image')->nullable();
            $table->string('title_description');
            $table->string('meta_description');
            $table->text('content');
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
        Schema::dropIfExists('news');
    }
}
