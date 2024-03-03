<?php

namespace Modules\Movie\App\Services\V1\Contracts;

use Modules\Movie\App\Http\Requests\V1\Front\CreateMovieRequest;
use Modules\Movie\App\Http\Requests\V1\Front\UpdateMovieRequest;
use Modules\Movie\App\Models\Movie;

interface MovieServiceContract
{
    public function store(CreateMovieRequest $request): Movie;
    public function update(Movie $movie, UpdateMovieRequest $request): Movie;
}
