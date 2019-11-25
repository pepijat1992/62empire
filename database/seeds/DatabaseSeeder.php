<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminsTableSeeder::class);
        $this->call(AgentsTableSeeder::class);
        // $this->call(UsersTableSeeder::class);
        $this->call(BanksTableSeeder::class);
        $this->call(GamesTableSeeder::class);
        $this->call(SettingsTableSeeder::class);
    }
}
