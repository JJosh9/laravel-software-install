<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('users')->truncate();

        $users = [
            [
                'name' => 'Prosper',
                'email' => 'prosper.laravel@unicodeveloper.com',
                'password' => Hash::make('prosper')
            ],
            [
               'name' => 'Prosper',
               'email' => 'seeder.otemuyiwa@gmail.com',
               'password' => Hash::make('prosper')
            ]
        ];

        DB::table('users')->insert($users);
    }
}
