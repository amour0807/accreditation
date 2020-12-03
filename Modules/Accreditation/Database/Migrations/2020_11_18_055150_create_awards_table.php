<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAwardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->string('last_name');
            $table->string('middle_initial')->nullable();
            $table->string('first_name');
            $table->bigInteger('acad_prgram_id')->unsigned();
            $table->foreign('acad_prgram_id')->references('id')->on('acad_prgrms');
            $table->string('scope');
            $table->string('category');
            $table->string('classification');
            $table->string('award');
            $table->string('title_competitions');
            $table->string('award_giving_body');
            $table->date('date_awarded');
            $table->string('venue');
            $table->string('award_cert')->nullable();
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
        Schema::dropIfExists('award');
    }
}
