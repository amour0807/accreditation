<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_exam', function (Blueprint $table) {
            $table->id();
            $table->string('licensure_exam');
            $table->string('exam_month');
            $table->year('exam_year');
            $table->integer('school_rank')->nullable();
            $table->integer('ftaker_passed');
            $table->integer('ftaker_failed');
            $table->integer('ftaker_cond');
            $table->integer('total_passed');
            $table->integer('total_failed');
            $table->integer('total_cond');
            $table->float('national_percent');
            $table->string('supporting_doc')->nullable();
            $table->boolean('archived');
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
        Schema::dropIfExists('board_exam');
    }
}
