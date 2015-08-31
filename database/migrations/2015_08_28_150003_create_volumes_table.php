<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolumesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volumes', function (Blueprint $table) {
            // COLUMNS
            $table->increments('id');
            $table->string('shorthand',25);
            $table->string('name',75);
            $table->timestamps();
            $table->softDeletes();

            // CONDITIONS
            $table->unique('shorthand');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('volumes');
    }
}
