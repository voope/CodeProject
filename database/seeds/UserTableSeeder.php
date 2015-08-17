<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \CodeProject\User::truncate();
        factory(\CodeProject\User::class, 10)->create();
    }
}
