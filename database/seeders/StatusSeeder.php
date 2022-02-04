<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $data = array(
      [
        'title' => 'Buffer',
        'slug' => 'buffer'
      ],
      [
        'title' => 'Working',
        'slug' => 'working'
      ],
      [
        'title' => 'Done',
        'slug' => 'done'
      ]
    );

    DB::table('statuses')->insert($data);
  }
}
