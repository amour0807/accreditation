<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHrReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_report', function (Blueprint $table) {
            $table->id();
            $table->string('semester');
            $table->string('school_year');
            $table->string('department');
            $table->string('no_Tpermanent');
            $table->string('no_Tprobationary');
            $table->string('no_Tcontractual');
            $table->string('no_Tpartime');
            $table->string('no_NTprobationary');
            $table->string('no_NTpermanent');
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
        Schema::dropIfExists('hr_report');
    }
}
