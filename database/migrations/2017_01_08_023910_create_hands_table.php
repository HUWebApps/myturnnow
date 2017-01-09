<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hands', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('meeting_id');
            //$table->foreign('meeting_id')->references('id')->on('meetings');
            $table->string('name');
            $table->boolean('raised');
            $table->boolean('calledon');
            $table->boolean('followup');
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
        Schema::drop('hands');
    }
}
