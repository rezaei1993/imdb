<?php

namespace Modules\Movie\App\Observers;

use Illuminate\Support\Facades\Log;
use Modules\Movie\App\Models\Movie;
use Modules\Movie\App\Repositories\V1\Mysql\MovieMysqlRepository;
use Modules\Movie\App\Services\V1\Contracts\ImdbCrawlerServiceContract;

class MovieObserver
{
    public function __construct(private readonly ImdbCrawlerServiceContract $imdbCrawlerServiceContract,
                                private readonly MovieMysqlRepository       $movieMysqlRepository)
    {
    }

    public function creating(Movie $movie): void
    {
        $data = $this->updateIMDBInfo($movie);
        $movie->imdb_rating = $data['imdb_rating'] ?? null;
        $movie->imdb_thumbnail = $data['imdb_thumbnail'] ?? null;
    }

    public function updating(Movie $movie): void
    {
        if ($movie->isDirty('imdb_id')) {
            $data = $this->updateIMDBInfo($movie);
            $movie->imdb_rating = $data['imdb_rating'] ?? null;
            $movie->imdb_thumbnail = $data['imdb_thumbnail'] ?? null;
        }
    }

    private function updateIMDBInfo(Movie $movie): ?array
    {
        if (!empty($movie->imdb_id)) {
            $htmlData = $this->imdbCrawlerServiceContract->getData(config('movie.imdb_base_url').$movie->imdb_id);

            if ($htmlData) {
                $data['imdb_rating'] = $this->imdbCrawlerServiceContract->extractRating($htmlData);
                $data['imdb_thumbnail'] = $this->imdbCrawlerServiceContract->extractBannerLink($htmlData);
            }
        }
        return $data ?? null;
    }
}
