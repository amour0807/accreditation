<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopnotchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topnotchers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('boardexam_id')->unsigned();
            $table->foreign('boardexam_id')->references('id')->on('board_exam');
            $table->string('name');
            $table->integer('rank');
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
        Schema::dropIfExists('topnotchers');
    }
}
