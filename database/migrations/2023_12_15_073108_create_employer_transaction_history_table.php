<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployerTransactionHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employer_transaction_history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('employer_id');
            $table->float('begin_balance');
            $table->float('transaction_amount');
            $table->float('end_balance');
            $table->timestamp('transaction_date');
            $table->text('action_name');
            $table->bigInteger('job_seeker_id')->nullable();
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
        Schema::dropIfExists('employer_transaction_history');
    }
}
