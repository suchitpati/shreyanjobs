<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Batch_jobs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('batch_jobs')->insert([
            'batch_job_name' => 'SEND_NEW_JOB_NOTIFICATION',
            'status' => 1,
            'created_at' =>now(),
            'updated_at' => now()

        ]);
    }
}
