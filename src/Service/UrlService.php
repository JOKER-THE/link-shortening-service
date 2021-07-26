<?php

namespace App\Service;

use App\Entity\Url;

class UrlService
{
    /**
     * @param Url $url
     * @return void
     */
    public function generateLink(Url $url): void
    {
        $link = '';

        while (($len = strlen($link)) < 8) {
            $size = 8 - $len;
            $bytes = random_bytes($size);
            $link .= substr(str_replace(['/', '+', '='], '', base64_encode($bytes)), 0, $size);
        }
        $url->setNewLink($link);
    }

    /**
     * @param Url $url
     * @return string
     */
    public function getLink(Url $url): string
    {
        $link = $url->getOriginalUrl();

        if (stristr($link, 'http://') === false && stristr($link, 'https://') === false) {
            $link = 'http://' . $link;
        }

        return $link;
    }

    /**
     * @param Url $url
     * @param string $baseUrl
     * @return string
     */
    public function getShortUrl(Url $url, string $baseUrl) : string
    {
        $link = $url->getNewLink();

        return $baseUrl . '/' . $link;
    }
}
