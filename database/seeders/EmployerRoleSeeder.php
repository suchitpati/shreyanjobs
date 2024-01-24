<?php

namespace Database\Seeders;

use App\Models\EmployerRole;
use Illuminate\Database\Seeder;

class EmployerRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EmployerRole::create([
            'name' => 'admin',
        ]);
        EmployerRole::create([
            'name' => 'employer',
        ]);
    }
}
