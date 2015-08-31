<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            // COLUMNS
            $table->increments('id');
            $table->integer('volume_id')->unsigned();
            $table->string('shorthand',25);
            $table->string('name',75);
            $table->timestamps();
            $table->softDeletes();

            // CONDITIONS
            $table->unique(array('volume_id','shorthand'));
            $table->foreign('volume_id')->references('id')->on('volumes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books');
    }
}
