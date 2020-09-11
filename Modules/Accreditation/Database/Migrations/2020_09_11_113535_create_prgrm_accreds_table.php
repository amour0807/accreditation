<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrgrmAccredsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('prgrm_accreds', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('accred_status_id')->unsigned();
            $table->foreign('accred_status_id')->references('id')->on('accred_stats');
            $table->bigInteger('acad_prgrm_id')->unsigned();
            $table->foreign('acad_prgrm_id')->references('id')->on('acad_prgrms');
            $table->date('visit_date');
            $table->date('from');
            $table->date('to');
            $table->string('pacucoa_cert')->nullable();
            $table->string('faap_cert')->nullable();
            $table->string('remarks')->nullable();

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
        Schema::dropIfExists('prgrm_accreds');
    }
}
