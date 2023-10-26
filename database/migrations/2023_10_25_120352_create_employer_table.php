<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer', function (Blueprint $table) {
            $table->id();
            $table->string('companyname');
            $table->string('companyurl')->nullable();
            $table->string('employername');
            $table->string('emailid');
            $table->string('password');
            $table->string('confirmpassword');
            $table->string('contactno')->nullable();
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->integer('otp');
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
        Schema::dropIfExists('employer');
    }
}
