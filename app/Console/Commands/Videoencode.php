<?php

namespace App\Console\Commands;

use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Format\Video\X264;
use Illuminate\Console\Command;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;

class Videoencode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:videoencode';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lowBitRate = (new X264)->setKiloBitrate(1000);
        $midBitRate = (new X264)->setKiloBitrate(2500);
        $highBitRate = (new X264)->setKiloBitrate(5000);

        $this->info('Converting Video MP4');
        try {
            FFMPEG::fromDisk('public')
                ->open('videos/vBbdyeVd5P6xtOdRjVxlCIvwXvHRnEMUSNrJIoEs.mp4')
                ->exportForHLS()
                ->addFormat($lowBitRate)
                ->addFormat($midBitRate)
                ->addFormat($highBitRate)
                ->onProgress(function($progress){
                    $this->info("Progress: {$progress}%");
                })
                ->toDisk('secret')
                ->save('video.m3u8');
        
            $this->info('Done');
        } catch (\Exception $e) {
            $this->error("Error: {$e->getMessage()}");
        }        
    }
}
