<?php

namespace Modules\Movie\App\Services\V1;

use Modules\Media\App\Services\V1\Contracts\MediaFileServiceContract;
use Modules\Movie\App\Http\Requests\V1\Front\CreateMovieRequest;
use Modules\Movie\App\Http\Requests\V1\Front\UpdateMovieRequest;
use Modules\Movie\App\Models\Movie;
use Modules\Movie\App\Repositories\V1\Mysql\MovieMysqlRepository;
use Modules\Movie\App\Services\V1\Contracts\MovieServiceContract;

class MovieService implements MovieServiceContract
{
    public function __construct(private readonly MovieMysqlRepository     $movieMysqlRepository,
                                private readonly MediaFileServiceContract $mediaFileServiceContract)
    {

    }

    public function store(CreateMovieRequest $request): Movie
    {

        $data = $request->validated();
        $data['video_id'] = $this->mediaFileServiceContract->publicUpload($request->file('video'))?->id;
        $data['thumbnail_id'] = $this->mediaFileServiceContract->publicUpload($request->file('thumbnail'))?->id;

        return $this->movieMysqlRepository->create($data);
    }

    public function update(Movie $movie, UpdateMovieRequest $request): Movie
    {
        $data = $request->validated();
        $data['video_id'] = $this->updateVideo($request, $movie);
        $data['thumbnail_id'] = $this->updateThumbnail($request, $movie);

        return $this->movieMysqlRepository->update($movie, $data);
    }


    public function updateVideo(UpdateMovieRequest $request, Movie $movie): ?int
    {
        if ($request->hasFile('video')) {

            if ($movie->video)
                $movie->video->delete();

            return $this->mediaFileServiceContract->publicUpload($request->file('video'))?->id;
        }
        return $movie->video_id;
    }


    public function updateThumbnail(UpdateMovieRequest $request, Movie $movie): ?int
    {
        if ($request->hasFile('thumbnail')) {

            if ($movie->thumbnail)
                $movie->thumbnail->delete();

            return $this->mediaFileServiceContract->publicUpload($request->file('thumbnail'))?->id;
        }
        return $movie->video_id;
    }
}
