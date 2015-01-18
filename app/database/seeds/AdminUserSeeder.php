<?php

use G6\FoundedInMk\Entities\User;

class AdminUserSeeder extends Seeder{


    public function run()
    {

        User::create([
            'name'      => 'admin',
            'email'     => 'admin@foundedin.mk',
            'password'  => Hash::make('admin123!')

        ]);
    }


}