<?php
// app/Helpers/helpers.php
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use FFMpeg\Format\Video\X264;
use ProtoneMedia\LaravelFFMpeg\Exporters\HLSExporter;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

function encodevideo($videopath)
    {
        $lowBitRate = (new X264)->setKiloBitrate(1000);
        $midBitRate = (new X264)->setKiloBitrate(2500);
        $highBitRate = (new X264)->setKiloBitrate(5000);
        Log::info('Encoding Video');
        try {
            FFMPEG::fromDisk('public')
                ->open('videos/'. $videopath)
                ->exportForHLS()
                ->addFormat($lowBitRate)
                ->addFormat($midBitRate)
                ->addFormat($highBitRate)
                ->onProgress(function($progress){
                    Log::info("Progress: {$progress}%");
                })
                ->toDisk('secret')
                ->save(Str::random(10).'video.m3u8');
                Log::info('Encoding Done');
        } catch (\Exception $e) {
            Log::error("Error: {$e->getMessage()}");
        }
    }
