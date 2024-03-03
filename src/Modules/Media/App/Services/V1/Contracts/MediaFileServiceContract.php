<?php


namespace Modules\Media\App\Services\V1\Contracts;

use Illuminate\Http\UploadedFile;
use Modules\Media\App\Models\Media;

interface MediaFileServiceContract
{
    /**
     * Uploads a file privately.
     *
     * @param UploadedFile $file
     * @param string|null $dir
     * @return Media|null
     */
    public static function privateUpload(UploadedFile $file, ?string $dir = null): ?Media;

    /**
     * Uploads a file publicly.
     *
     * @param UploadedFile $file
     * @param string|null $dir
     * @return Media|null
     */
    public static function publicUpload(UploadedFile $file, ?string $dir = null): ?Media;



    static function stream(Media $media);

    /**
     * Deletes the media.
     *
     * @param Media $media
     * @return mixed
     */
    public static function delete(Media $media);

    /**
     * Generates a thumbnail for the media.
     *
     * @param Media $media
     * @return mixed
     */
    public static function thumb(Media $media);

    /**
     * Retrieves the allowed file extensions.
     *
     * @return string
     */
    public static function getExtensions(): string;
}
