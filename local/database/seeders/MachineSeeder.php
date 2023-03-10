<?php

namespace Database\Seeders;

use App\Models\Machine;
use Illuminate\Database\Seeder;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Machine::create([
            'line_id'       => '1',
            'name'          => 'IB5',
            'mac_address'   => '4C-03-4F-E5-3B-EC'
        ]);
    }
}
