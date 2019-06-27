<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id')->nullable();
            $table->integer('country_id')->references('id')->on('countries');
            $table->string('slug');
            $table->string('title');
            $table->string('logo');
            $table->text('about');
            $table->string('phones');
            $table->string('website');
            $table->string('emails');
            $table->string('address');
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
        Schema::dropIfExists('companies');
    }
}
