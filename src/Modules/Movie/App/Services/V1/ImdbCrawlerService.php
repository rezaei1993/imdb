<?php
namespace Modules\Movie\App\Services\V1;

use DOMDocument;
use Modules\Movie\App\Services\V1\Contracts\ImdbCrawlerServiceContract;

class ImdbCrawlerService implements ImdbCrawlerServiceContract
{

    public function getData($url): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error: '.curl_error($ch);
            return false;
        }

        curl_close($ch);

        return $response;
    }

    public function extractRating($html): ?string
    {
        preg_match('/<span class="sc-bde20123-1 cMEQkK">(.*?)<\/span>/', $html, $matches);
        if (isset($matches[1])) {
            return $matches[1];
        }
        return null;

    }

    public function extractBannerLink($html): ?string
    {
        $dom = new DOMDocument();

        @$dom->loadHTML($html);

        $scripts = $dom->getElementsByTagName('script');

        foreach ($scripts as $script) {
            if ($script->getAttribute('type') === "application/ld+json") {

                $jsonData = $script->nodeValue;
                $data = json_decode($jsonData, true);

                if (isset($data['image'])) {
                    return $data['image'];
                }
            }
        }

        return null;
    }
}
