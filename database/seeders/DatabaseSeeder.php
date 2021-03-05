<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {DB::table('users')->insert([
        'userName' => "asimwela",
        'email' => 'as@gmail.com',
        'isAdmin'=>true,
        'firstName'=>'Augustine',
        'lastName'=>'Simwela',
        'password' => bcrypt('12345'),
    ]);

        DB::table('users')->insert([
            'userName' => "auga",
            'email' => 'a@gmail.com',
            'isAdmin'=>false,
            'firstName'=>'Augustine',
            'lastName'=>'Simwela',
            'password' => bcrypt('12345'),
        ]);
    }
}
