<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChaptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chapters', function (Blueprint $table) {
            // COLUMNS
            $table->increments('id');
            $table->integer('book_id')->unsigned();
            $table->integer('number')->unsigned();
            $table->text('summary')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // CONDITIONS
            $table->unique(array('book_id','number'));
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('chapters');
    }
}
