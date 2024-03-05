<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBatchJobLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('batch_job_log', function (Blueprint $table) {
            $table->id();
            $table->string('batch_job_name');
            $table->string('status');
            $table->integer('process_count');
            $table->integer('email_sent_count');
            $table->timestamp('job_start_time')->nullable();
            $table->timestamp('job_end_time')->nullable(); // Set a default value (current timestamp)
            $table->text('error_message')->nullable();
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
        Schema::dropIfExists('batch_job_log');
    }
}
