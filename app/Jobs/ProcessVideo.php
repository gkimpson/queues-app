<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // public $timeout = 1;     // terminate job if process hasn't finished by this time to prevent it getting stuck
    // public $tries = -1;      // max no of retries OR use -1 for unlimited number of retries
    // public $backoff = [2, 5, 10];     // back off for x seconds before each retry

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        throw new Exception("Error Processing Request");
        sleep(3);

        info('Video processed!');
    }

    // public function retryUntil()
    // {
    //     return now()->addMinute();
    // }

    public function failed($e)
    {
        info('the job has failed:');
    }
}
