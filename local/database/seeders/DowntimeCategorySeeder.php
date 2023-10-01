<?php

namespace Database\Seeders;

use App\Models\DowntimeCategory;
use Illuminate\Database\Seeder;

class DowntimeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $downtimeCategory = new DowntimeCategory();
        $downtimeCategory->name = 'management';
        $downtimeCategory->save();

        $downtimeCategory = new DowntimeCategory();
        $downtimeCategory->name = 'waste';
        $downtimeCategory->save();

        $downtimeCategory = new DowntimeCategory();
        $downtimeCategory->name = 'off';
        $downtimeCategory->save();
    }
}
