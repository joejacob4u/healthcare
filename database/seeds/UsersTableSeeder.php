<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->insert([
          'name' => 'Jim Burlew',
          'type' => 'admin',
          'email' => 'jimburlew@gmail.com',
          'password' => bcrypt('jimburlew'),
      ]);
    }
}
