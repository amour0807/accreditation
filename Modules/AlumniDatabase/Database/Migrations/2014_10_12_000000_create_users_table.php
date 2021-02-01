<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql2')->create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('id_number');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('user_role')->nullable();
            $table->bigInteger('school_id')->unsigned();
            $table->foreign('school_id')->references('id')->on('qasystem.schools');
            $table->bigInteger('program_id')->unsigned();
            $table->foreign('program_id')->references('id')->on('qasystem.acad_prgrms');
            $table->string('current_address')->nullable();
            $table->string('present_address')->nullable();
            $table->string('cell_num')->nullable();
            $table->string('landline')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('major')->nullable();
            $table->string('semester')->nullable();
            $table->string('school_year')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remarks');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
