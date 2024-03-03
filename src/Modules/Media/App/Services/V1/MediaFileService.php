<?php

namespace Modules\Media\App\Services\V1;

use Modules\Media\App\Services\V1\Contracts\FileServiceContract;
use Modules\Media\App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Modules\Media\App\Services\V1\Contracts\MediaFileServiceContract;

class MediaFileService implements MediaFileServiceContract
{
    private static $file;
    private static $type;
    private static $isPrivate;
    /**
     * @var mixed|null
     */
    private static mixed $directory;

    /**
     * @param UploadedFile $file
     * @param $dir
     * @return Media|null
     */
    public static function privateUpload(UploadedFile $file, $dir = null): ?Media
    {
        self::$file = $file;
        self::$type = "private/";
        self::$directory = isset($dir) ? $dir . '/' : null;
        self::$isPrivate = true;

        return self::upload();
    }

    /**
     * @param UploadedFile $file
     * @param $dir
     * @return Media|null
     */
    public static function publicUpload(UploadedFile $file, $dir = null): ?Media
    {
        self::$file = $file;
        self::$type = 'public/';
        self::$directory = isset($dir) ? $dir . '/' : null;
        self::$isPrivate = false;
        return self::upload();
    }

    /**
     * @return Media|void
     */
    private static function upload()
    {
        $extension = self::normalizeExtension(self::$file);
        foreach (config('media.MediaTypeServices') as $type => $service) {
            if (in_array($extension, $service['extensions'])) {
                return self::uploadByHandler(new $service['handler'], $type);
            }
        }
    }


    static function stream(Media $media)
    {
        foreach (config('mediaFile.MediaTypeServices') as $type => $service) {
            if ($media->type == $type) {
                return $service['handler']::stream($media);
            }
        }
    }

    public static function delete(Media $media)
    {
        foreach (config('media.MediaTypeServices') as $type => $service) {
            if ($media->type == $type) {
                return $service['handler']::delete($media);
            }
        }
    }

    /**
     * @param $file
     * @return string
     */
    private static function normalizeExtension($file): string
    {
        return strtolower($file->getClientOriginalExtension());
    }

    /**
     * @return string
     */
    private static function filenameGenerator(): string
    {
        return uniqid();
    }

    /**
     * @param FileServiceContract $service
     * @param $key
     * @return Media
     */
    private static function uploadByHandler(FileServiceContract $service, $key): Media
    {
        $media = new Media();
        $media->files = $service::upload(self::$file, self::filenameGenerator(), self::$type . self::$directory);
        $media->type = $key;
        $media->uuid = (string) Str::uuid();
        $media->directory = self::$directory;
        $media->user_id = auth()->id() ?? null;
        $media->filename = self::$file->getClientOriginalName();
        $media->size = self::$file->getSize();
        $media->is_private = self::$isPrivate;
        $media->save();
        return $media;
    }

    /**
     * @param Media $media
     * @return void
     */
    public static function thumb(Media $media)
    {
        foreach (config('media.MediaTypeServices') as $type => $service) {
            if ($media->type == $type) {
                return $service['handler']::thumb($media);
            }
        }
    }

    /**
     * @return string
     */
    public static function getExtensions(): string
    {
        $extensions = [];
        foreach (config('media.MediaTypeServices') as $service) {
            foreach ($service['extensions'] as $extension) {
                $extensions[] = $extension;
            }
        }

        return implode(',', $extensions);
    }
}
