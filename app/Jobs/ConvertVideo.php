<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use FFMpeg;
use FFMpeg\Filters\Video\VideoFilters;
use FFMpeg\Coordinate\Dimension;
use FFMpeg\Format\Video\X264;
class ConvertVideo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 600;           // terminate job if process hasn't finished by this time to prevent it getting stuck
    public $tries = 2;               // max no of retries OR use -1 for unlimited number of retries
    public $backoff = [2, 5, 10];    // back off for x seconds before each retry, wait 2 secs, then 5 secs, then 10 seconds (when doing a retry)

    public $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        info('processing job....');

        $this->lowResolutionConversion();
        $this->midResolutionConversion();
        $this->highResolutionConversion();

        info('completed job');

        // could add logic here to save in a database that this individual file has been processed & converted
        // into the relevant format/dimensions for streaming
    }

    private function highResolutionConversion()
    {
        $this->videoConversion('1920', '1080', 'high-res');
    }

    private function midResolutionConversion()
    {
        $this->videoConversion('1280', '720', 'mid-res');
    }

    private function lowResolutionConversion()
    {
        $this->videoConversion('640', '480', 'low-res');
    }

    private function videoConversion(string $width = '640', string $height = '480', string $label)
    {
        info("processing {$label} conversion...");

        FFMpeg::fromDisk('public')
        ->open($this->video['path'])
        ->export()
        // ->onProgress(function ($percentage, $remaining, $rate) {
        //     echo "\n{$remaining} seconds left at rate: {$rate}";
        // })
        ->toDisk('public')
        ->inFormat(new \FFMpeg\Format\Video\X264)
        ->resize($width, $height)
        ->save('streaming-' . time() .'-' . $width .'-' . $height . '.mp4');

        info("{$label} conversion complete");
    }

}
