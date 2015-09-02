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
        \CodeProject\Entities\User::truncate();

        factory(\CodeProject\Entities\User::class)->create([
            'name' => 'Paulo',
            'email' => 'paulo@voope.com.br',
            'password' => bcrypt(123),
            'remember_token' => str_random(10),
        ]);

        factory(\CodeProject\Entities\User::class, 10)->create();
    }
}
