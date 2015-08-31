<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVersesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verses', function (Blueprint $table) {
            // COLUMNS
            $table->increments('id');
            $table->integer('chapter_id')->unsigned();
            $table->integer('number')->unsigned();
            $table->text('scripture')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // CONDITIONS
            $table->unique(array('chapter_id','number'));
            $table->foreign('chapter_id')->references('id')->on('chapters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('verses');
    }
}
