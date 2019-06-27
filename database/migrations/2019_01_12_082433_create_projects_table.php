<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sort_id')->nullable();
            $table->string('slug');
            $table->string('title');
            $table->string('name');
            $table->string('image');
            $table->string('title_description');
            $table->string('meta_description');
            $table->text('content');
            $table->char('lang', 4);
            $table->integer('status')->default(1);
            $table->timestamps();
        });

        Schema::table('apps', function (Blueprint $table) {
            $table->integer('project_id')->unsigned()->after('id');
            $table->foreign('project_id')->references('id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
