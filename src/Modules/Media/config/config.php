<?php

return [
    'name' => 'Media',
    "MediaTypeServices" => [
        "video" => [
            "extensions" =>[
                "avi", "mp4", "mkv"
            ],
            "handler" => Modules\Media\App\Services\V1\VideoFileService::class,
        ],
        "image" => [
            "extensions" =>[
                "jpg", "jpeg", "png"
            ],
            "handler" => Modules\Media\App\Services\V1\ImageFileService::class,

        ],
    ]
];
