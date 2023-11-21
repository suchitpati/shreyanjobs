<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTechnicalSkillToJobTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_jobs', function (Blueprint $table) {
            $table->text('technical_skill')->nullable()->after('additional_detail');

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
            $table->dropColumn('technical_skill');
        });
    }
}
