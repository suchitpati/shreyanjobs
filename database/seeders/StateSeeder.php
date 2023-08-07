<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $states = [
            ['name' => 'State 1', 'code' => 'S1', 'country_id' => 1], 
            ['name' => 'State 2', 'code' => 'S2', 'country_id' => 2], 
           
        ];

      
        State::insert($states);
    }
}
