<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;


class UserSeederPrueba extends Seeder
{
  
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::create(['eid' => 'P0606','email'=> 'samuelpersonalcifd@gmail.com','password' => bcrypt('Comision2024.') ])-> assignRole('usuario');
        //User::create(['eid' => 'ARH06','email'=> 'samueljefearh@gmail.com','password' => bcrypt('Comision2024.') ])-> assignRole('jefeARH');
        User::create(['eid' => 'ADM06','email'=> 'smldmnxpdnts@gmail.com','password' => bcrypt('MERLA2025.') ])-> assignRole('admin');
    }
}
