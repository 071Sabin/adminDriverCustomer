<?php

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
    {
        // $this->call(UsersTableSeeder::class);

        DB::table('admin')->insert([
            'name' => 'admin1',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('sabin123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // setting first rate per mile as 0 for last and current rates.
        DB::table('ratepermile')->insert([
            'current_rate' => 0,
            'last_rate' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // setting first minimun charge as 0 for last and current charges.
        DB::table('mincharge')->insert([
            'current_min_charge' => 0,
            'last_min_charge' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('commissionrate')->insert([
            'current_com_rate' => 0,
            'last_com_rate' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}