<?php

namespace Modules\Movie\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Media\App\Models\Media;
use Modules\Movie\Database\factories\MovieFactory;

/**
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $imdb_thumbnail
 * @property float $price
 * @property string $imdb_id
 * @property float $imdb_rating
 * @property int $video_id
 * @property int $thumbnail_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Modules\Media\App\Models\Media $video
 * @property-read \Modules\Media\App\Models\Media $thumbnail
 */
class Movie extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'title',
        'description',
        'imdb_thumbnail',
        'price',
        'imdb_id',
        'imdb_rating',
        'video_id',
        'thumbnail_id'
    ];


    public function video(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'video_id');
    }

    public function thumbnail(): BelongsTo
    {
        return $this->belongsTo(Media::class,'thumbnail_id');
    }

    protected static function newFactory(): MovieFactory
    {
        return MovieFactory::new();
    }
}
