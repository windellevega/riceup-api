<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$users = [
        	[
	        	'username' => 'windellevega',
	        	'password' => Hash::make('pass123'),
	        	'firstname' => 'Windelle John',
	        	'middlename' => 'Gajes',
	        	'lastname' => 'Vega',
	        	'address' => 'Penablanca, Cagayan',
	        	'business_name' => 'W Business Corp.',
	        	'mobile_no' => '09171234567',
	        	'email' => 'windellevega@example.com',
	        	'years_in_business' => 5,
	        	'photo_url' => '/photos/profile/default.jpg',
	        	'is_farmer' => 0,
	        	'history' => null,
	        	'years_in_farming' => null
	        ],
	        [
	        	'username' => 'apayrahyan',
	        	'password' => Hash::make('pass123'),
	        	'firstname' => 'Ryan Joseph',
	        	'middlename' => 'Tinaya',
	        	'lastname' => 'Torrado',
	        	'address' => 'Alcala, Cagayan',
	        	'business_name' => null,
	        	'mobile_no' => '09172461234',
	        	'email' => 'apayrahyan@example.com',
	        	'years_in_business' => null,
	        	'photo_url' => '/photos/profile/default.jpg',
	        	'is_farmer' => 1,
	        	'history' => 'Farming is Life',
	        	'years_in_farming' => 5
	        ],
	        [
	        	'username' => 'coaxfiber',
	        	'password' => Hash::make('pass123'),
	        	'firstname' => 'Elton John Emmanuel',
	        	'middlename' => 'Carag',
	        	'lastname' => 'Bagne',
	        	'address' => 'Solana, Cagayan',
	        	'business_name' => null,
	        	'mobile_no' => '09173692468',
	        	'email' => 'coaxfiber@example.com',
	        	'years_in_business' => null,
	        	'photo_url' => '/photos/profile/default.jpg',
	        	'is_farmer' => 1,
	        	'history' => 'Farming Since Birth',
	        	'years_in_farming' => 23
	        ]
	    ];
        DB::table('users')->insert($users);
    }
}
