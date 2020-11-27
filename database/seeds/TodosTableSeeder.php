<?php

use Illuminate\Database\Seeder;

class TodosTableSeeder extends Seeder
{
    public function run()
    {
        $replies = factory(\App\Models\Todo::class)->times(1000)->create();
    }

}

