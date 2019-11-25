<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        'App\Console\Commands\RecordGi998',
        // 'App\Console\Commands\RecordScr2',
        'App\Console\Commands\RecordXe88',
        'App\Console\Commands\RecordPussy888',
        'App\Console\Commands\RecordGoldenf',
        'App\Console\Commands\RecordApi918',
        'App\Console\Commands\RecordJoker',
        'App\Console\Commands\RecordPlaytech',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('record:gi998');
        // $schedule->command('record:scr2');
        $schedule->command('record:xe88');
        $schedule->command('record:pussy888');
        $schedule->command('record:goldenf');
        $schedule->command('record:mega888');
        $schedule->command('record:api918');
        $schedule->command('record:joker');
        $schedule->command('record:playtech');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
