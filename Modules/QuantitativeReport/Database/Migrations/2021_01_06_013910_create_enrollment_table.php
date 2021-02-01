<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollment', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('school_id')->unsigned();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            
            $table->bigInteger('acad_prog_id')->unsigned();
            $table->foreign('acad_prog_id')->references('id')->on('acad_prgrms')->onDelete('cascade');

            $table->string('semester');
            $table->string('school_year');
            $table->integer('freshmen')->nullable();
            $table->integer('transfery')->nullable();
            $table->integer('old_student')->nullable();
            $table->integer('returnee')->nullable();
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
        Schema::dropIfExists('enrollment');
    }
}
