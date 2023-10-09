<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeekersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seekers', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('email');
            $table->string('password');
            $table->integer('gender');
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('contact_number')->nullable();
            $table->string('work_authorization')->nullable();
            $table->integer('total_experience')->nullable();
            $table->string('primary_skill')->nullable();
            $table->integer('primary_skill_experience')->nullable();
            $table->string('secondary_skill')->nullable();
            $table->integer('secondary_skill_experience')->nullable();
            $table->string('resume')->nullable();
            $table->string('otp')->nullable();
            $table->integer('is_active')->nullable();
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
        Schema::dropIfExists('seekers');
    }
}
