<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    
    public function run()
    {
        User::create([
            'phone_number' => '+8615641572188',
        ]);
    }
}
