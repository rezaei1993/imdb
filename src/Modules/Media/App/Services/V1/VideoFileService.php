<?php

namespace Modules\Media\App\Services\V1;

use FFMpeg\Format\Video\X264;
use Modules\Media\App\Services\V1\Contracts\FileServiceContract;
use Modules\Media\App\Models\Media;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;

class VideoFileService extends DefaultFileService implements FileServiceContract
{
    public static function upload($file, $filename, $type = 'private/'): array
    {
        $filename = uniqid();
        $extension = $file->getClientOriginalExtension();
        Storage::putFileAs($type, $file, $filename.'.'.$extension);
        $hlsFilename = $filename.'.m3u8';
        self::convertToHLS( $filename, $extension, $hlsFilename);

        return [
            "video" => $filename.'.'.$extension,
            "hls" => $hlsFilename
        ];
    }

    public static function convertToHLS($filename, $extension, $outputFilename)
    {
        $lowBitrateFormat  = (new X264)->setKiloBitrate(500);
        $midBitrateFormat  = (new X264)->setKiloBitrate(1500);
        $highBitrateFormat = (new X264)->setKiloBitrate(3000);

        FFMpeg::fromDisk('public')
            ->open($filename.'.'.$extension)
            ->exportForHLS()
            ->toDisk('public')
            ->addFormat($lowBitrateFormat)
            ->addFormat($midBitrateFormat)
            ->addFormat($highBitrateFormat)
            ->save($outputFilename);
    }

    public static function thumb(Media $media)
    {
        return url("/img/video-thumb.png");
    }


    public static function getFilename(): string
    {
        return (static::$media->is_private ? 'private/' : 'public/').static::$media->directory.static::$media->files['video'];
    }
}
