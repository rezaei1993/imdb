<?php

namespace Modules\Movie\App\Repositories\V1\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Modules\Movie\App\Models\Movie;

interface MovieRepositoryContract
{
    public function all(): Collection|array;
    public function create(array $data): Movie;
    public function update(Movie $movie,array$data): Movie;
}
