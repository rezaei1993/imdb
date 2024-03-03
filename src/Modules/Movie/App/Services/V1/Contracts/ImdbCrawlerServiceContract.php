<?php
namespace Modules\Movie\App\Services\V1\Contracts;

interface ImdbCrawlerServiceContract
{
    public function getData($url): string;
    public function extractRating($html): ?string;
    public function extractBannerLink($html): ?string;
}
