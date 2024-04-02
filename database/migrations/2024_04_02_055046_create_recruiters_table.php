<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecruitersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recruiters', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->string('emailid');
            $table->string('contactno')->nullable();
            $table->string('password');
            $table->string('companyname');
            $table->string('companyurl')->nullable();
            $table->string('last_login_date')->nullable();
            $table->string('is_active');
            $table->integer('otp')->nullable();;
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
        Schema::dropIfExists('recruiters');
    }
}
