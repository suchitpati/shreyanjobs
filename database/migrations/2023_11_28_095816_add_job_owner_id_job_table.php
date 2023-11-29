<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJobOwnerIdJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_jobs', function (Blueprint $table) {
            $table->text('job_owner_id')->after('technical_skill');
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
            $table->dropColumn('job_owner_id');
        });
    }
}
