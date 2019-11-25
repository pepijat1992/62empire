<?php

use Illuminate\Database\Seeder;
use App\Agent;

class AgentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Agent::create([
            'username' => 'agent1',
            'password' => bcrypt('123456'),
        ]);

        Agent::create([
            'username' => 'agent11',
            'agent_id' => 1,
            'password' => bcrypt('123456'),
        ]);

        Agent::create([
            'username' => 'agent12',
            'agent_id' => 1,
            'password' => bcrypt('123456'),
        ]);
    }
}
