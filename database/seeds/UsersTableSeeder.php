<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

// Model
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(array(
          'id'            => "2886652",
          'username'      => "nogoshop",
          'name'          => "Gundam Mokit Nogo _ Gmail",
          'email'         => "GundamMokitNogo_Gmail@gmail.com"
        ));

        User::create(array(
          'id'            => "1979833",
          'username'      => "jirolu_toys",
          'name'          => "jirolu toys",
          'email'         => "jirolu_toys@gmail.com"
        ));

        User::create(array(
          'id'            => "2166751",
          'username'      => "kaoshero",
          'name'          => "kaoshero hobbies",
          'email'         => "kaoshero@gmail.com"
        ));

        User::create(array(
          'id'            => "9500417",
          'username'      => "otaheaven",
          'name'          => "Ota Heaven",
          'email'         => "otaheaven@gmail.com"
        ));




    }
}
