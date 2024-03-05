<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

;



class Seeker extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0;$i<200;$i++)
        {

                DB::table('subscription')->insert([
                'skill' => 'java',
                'seeker_id' => 18 + $i,

            ]);
        }
    }
}
