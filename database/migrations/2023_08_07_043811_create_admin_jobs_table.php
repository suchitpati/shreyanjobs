
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('country');
            $table->string('state')->nullable();
            $table->boolean('remote')->default(false);
            $table->integer('search_count')->default(0);
            $table->string('skill');
            $table->integer('year_of_experience');
            $table->string('employment_type');
            $table->string('job_title');
            $table->string('short_description');
            $table->text('detailed_description');
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
        Schema::dropIfExists('admin_jobs');
    }
}
