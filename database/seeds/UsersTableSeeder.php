<?php

use Illuminate\Database\Seeder;
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
        User::create([
        'name'            => 'Binaya Thapa',
        'email'           => 'satik.thapa@gmail.com',
        'address1'        => 'Thapagaun',
        'address2'        => 'Thapagaun',
        'city'            => 'Banepa',
        'pincode'         => '123456',
        'state'           => 'Bagmati Pradesh',
        'country'         => 'Nepal',
        'mnumber'         => '9876543210',
        'alternativemno'  => '9876543211',
        'role'            => 'admin',
        'status'          => '1',
        'password'        => bcrypt('123456789'),
        ]);

        User::create([
            'name'            => 'Sudip Kumar Bajgain',
            'email'           => 'sudipbajgain550@gmail.com',
            'address1'        => 'Nala',
            'address2'        => 'Kakre',
            'city'            => 'Banepa',
            'pincode'         => '123456',
            'state'           => 'Bagmati Pradesh',
            'country'         => 'Nepal',
            'mnumber'         => '9876543210',
            'alternativemno'  => '9876543211',
            'role'            => 'admin',
            'status'          => '1',
            'password'        => bcrypt('123456789'),
            ]);

    }
}
