<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailSendStatusToAdminJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_jobs', function (Blueprint $table) {
            $table->integer('email_send_status')->default(0)->after('job_owner_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_jobs', function (Blueprint $table) {
            $table->dropColumn('email_send_status');
        });
    }
}
