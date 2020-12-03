<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstAwardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inst_award', function (Blueprint $table) {
            $table->id();
            $table->string('award');
            $table->date('from')->nullable();;
            $table->date('to')->nullable();;
            $table->string('venue')->nullable();;
            $table->string('award_giving_body');
            $table->string('supporting_doc')->nullable();
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
        Schema::dropIfExists('inst_award');
    }
}
