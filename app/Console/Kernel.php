<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Task;
use Carbon\Carbon;
use App\Jobs\SendNotificationEmail;
use App\Mail\TomorrowTaskExpiresEmail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        
        $schedule->call(function() {
        
					$tasks = Task::all();
					$currentTime = Carbon::now();
					
					foreach($tasks as $task) {
							if ($task->expires_at == null || $task->is_expired) {
								continue;
							} else {
									$expires = Carbon::parse($task->expires_at);

									if ($expires->copy()->subDay() <= $currentTime && !$task->expr_tmrw_email_queued) {
										SendNotificationEmail::dispatch( $task, new TomorrowTaskExpiresEmail($task) );
										$task->update(['expr_tmrw_email_queued' => true]);
									}
									
									if ($expires <= $currentTime) {
										$task->update(['is_expired' => true]);
									}
								}
					}
					
        })->everyMinute();
        
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
