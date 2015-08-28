<?php

use Illuminate\Database\Seeder;

class ProjectMemberTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \CodeProject\Entities\ProjectMembers::truncate();
        factory(\CodeProject\Entities\ProjectMembers::class, 10)->create();
    }
}
