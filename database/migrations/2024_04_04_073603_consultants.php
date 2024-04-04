<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Consultants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultants', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('work_authorization')->nullable();
            $table->string('relocate')->nullable();
            $table->string('primary_skill')->nullable();
            $table->integer('primary_skill_experience')->nullable();
            $table->string('secondary_skill')->nullable();
            $table->integer('secondary_skill_experience')->nullable();
            $table->string('resume')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('new_job_report_time')->nullable();
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
        Schema::dropIfExists('consultants');
    }
}
