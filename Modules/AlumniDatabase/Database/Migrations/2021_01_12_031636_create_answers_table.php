<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('answers', function (Blueprint $table) {
            $table->id();  
            $table->bigInteger('alumni_id')->unsigned();
            $table->foreign('alumni_id')->references('id')->on('alumni.users');
            $table->bigInteger('question_id')->unsigned();
            $table->foreign('question_id')->references('id')->on('alumni.questions');
            $table->string('answer');
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
        Schema::dropIfExists('answers');
    }
}
