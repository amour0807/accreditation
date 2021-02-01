<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateScholarDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scholar_discounts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('scholarship_id')->unsigned();
            $table->foreign('scholarship_id')->references('id')->on('scholars');
            $table->string('school_year');
            $table->integer('fno');
            $table->double('fphp');
            $table->integer('sno');
            $table->double('sphp');
            $table->integer('stno');
            $table->double('stphp');
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
        Schema::dropIfExists('scholar_discounts');
    }
}
