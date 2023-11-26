<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    	$createUser = [[
        	'name' => 'Owner',
        	'email' => 'owner@mail.com',
        	'level_id' => '1',
        	'active' => '1',
        	'password' => bcrypt('owner')
        ],
    	[
        	'name' => 'Admin',
        	'email' => 'admin@mail.com',
        	'level_id' => '2',
        	'active' => '1',
        	'password' => bcrypt('admin')
        ],
    	[
        	'name' => 'Member',
        	'email' => 'member@mail.com',
        	'level_id' => '3',
        	'active' => '1',
        	'password' => bcrypt('member')
        ]];
        
        User::insert($createUser);
    }
}
