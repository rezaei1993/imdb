<?php

namespace Modules\Media\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Media\App\Services\V1\MediaFileService;
use Modules\Media\Database\Factories\MediaFactory;
/**
 * @property int $id
 * @property array $files
 * @property string $uuid
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $thumb
 */
class Media extends Model
{
    use HasFactory;

    protected $casts = [
        'files' => 'json'
    ];

    public function download(): string
    {
        return route('media.download', ['media' => $this->id]);
    }


    public function secureDownload(): string
    {
        return route('secure.media.download', ['uuid' => $this->uuid]);
    }


    protected static function booted(): void
    {
        static::deleting(function ($media) {
            MediaFileService::delete($media);
        });
    }

    public function getThumbAttribute()
    {
        return MediaFileService::thumb($this);
    }

    public function getUrl($quality = "original"): string
    {
        return "/storage/" . $this->files[$quality];
    }

    protected static function newFactory(): MediaFactory
    {
        return MediaFactory::new();
    }
}
