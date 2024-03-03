<?php

namespace Modules\Media\App\Repositories\V1\Contracts;

use Modules\Media\App\Models\Media;

interface MediaRepositoryContract
{
    public static function create(array $data) :array ;

    public static function delete(Media $media);
}
