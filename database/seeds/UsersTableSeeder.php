<?php

use Illuminate\Database\Seeder;

use \App\Models\User;
use \Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => 'mbournigal',
            'name' => 'bournigal',
            'firstname' => 'maël',
            'email' => 'mbournigal@hotmail.fr',
            'password' => bcrypt('Bournigaldu44330'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
