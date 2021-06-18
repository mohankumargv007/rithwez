<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
	        'first_name' => 'Aspire',
	        'last_name' => '',
	        'email' => 'aspire@gmail.com',
	        'email_verified_at' => date('Y-m-d H:i:s'),
            'role' => 'Admin',
	        'status' => 1,
	        'password' => Hash::make('aspire123'),
	    ]);
    }
}
