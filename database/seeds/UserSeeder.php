<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$no_of_users = 10;
    	for($i=0; $i<$no_of_users; $i++) {
	        DB::table('users')->insert([
		        'first_name' => Str::random(10),
		        'last_name' => Str::random(10),
		        'email' => Str::random(10).'@gmail.com',
		        'email_verified_at' => date('Y-m-d H:i:s'),
		        'status' => 1,
		        'password' => Hash::make('hellohello'),
		    ]);
    	}
    }
}
