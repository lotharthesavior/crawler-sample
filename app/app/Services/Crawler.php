<?php

namespace App\Services;

use DOMDocument;
use HtmlParser\Parser;
use Illuminate\Support\Facades\Http;

class Crawler implements CrawlerInterface
{
    /**
     * In Seconds.
     *
     * @var float|null
     */
    protected ?float $executionTime = null;

    protected ?int $statusCode = null;

    /**
     * @var array
     */
    protected array $imagesSrcs = [];

    /**
     * @var array
     */
    protected array $linksSrcs = [];

    /**
     * @var array
     */
    protected array $internalLinks = [];

    /**
     * @var array
     */
    protected array $externalLinks = [];

    /**
     * @var int
     */
    protected ?int $wordsCount = null;

    /**
     * @var int|null
     */
    protected ?int $titleLength = null;

    public function __get($name)
    {
        return $this->$name;
    }

    public function crawl(string $url): self
    {
        $executionStartTime = microtime(true);
        $html = $this->getPageContents($url);
        $executionEndTime = microtime(true);

        $doc = Parser::parse($html);

        $this->executionTime = number_format($executionEndTime - $executionStartTime, 2, '.', '');
        $this->imagesSrcs = $this->getImagesSrc($doc);
        $this->linksSrcs = $this->getLinksSrc($doc);
        $this->externalLinks = $this->getExternalLinks($doc);
        $this->internalLinks = $this->getInternalLinks($doc);
        $this->wordsCount = $this->getWordsCount($html);
        $this->titleLength = $this->getTitleLength($doc);

        return $this;
    }

    public function getPageContents(string $url): string
    {
        $response = Http::get($url);
        $this->statusCode = $response->status();
        return $response;
    }

    /**
     * @param DOMDocument $doc
     * @return array
     */
    private function getImagesSrc(DOMDocument $doc): array {
        $result = [];

        foreach($doc->getElementsByTagName('img') as $image) {
            $src = $image->getAttribute('src');

            if (!empty($src)) {
                $result[] = $src;
                continue;
            }

            $src = $image->getAttribute('data-src');
            if (!empty($src)) {
                $result[] = $src;
            }
        }

        return array_unique($result);
    }

    /**
     * @param DOMDocument $doc
     * @return array
     */
    private function getLinksSrc(DOMDocument $doc): array {
        $result = [];
        foreach ($doc->getElementsByTagName('a') as $link) {
            $result[] = $link->getAttribute('href');
        }
        return array_unique($result);
    }

    /**
     * @param DOMDocument $doc
     * @return array
     */
    private function getInternalLinks(DOMDocument $doc): array {
        $imagesSrcs = $this->linksSrcs ?? $this->getLinksSrc($doc);
        $external = $this->externalLinks ?? $this->getExternalLinks($doc);
        return array_unique(array_filter($imagesSrcs, function ($item) use ($external) {
            return !in_array($item, $external);
        }));
    }

    /**
     * @param DOMDocument $doc
     * @return array
     */
    private function getExternalLinks(DOMDocument $doc): array {
        $imagesSrcs = $this->linksSrcs ?? $this->getLinksSrc($doc);
        return array_unique(array_filter($imagesSrcs, function ($item) {
            return preg_match('/^(www\.|http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)/', $item, $matches, PREG_OFFSET_CAPTURE);
        }));
    }

    /**
     * @param string $html
     * @return int
     */
    private function getWordsCount(string $html): int {
        $filters = [
            '@<script[^>]*?>.*?</script>@si',
            '@<head>.*?</head>@siU',
            '@<style[^>]*?>.*?</style>@siU',
            '@<![\s\S]*?--[ \t\n\r]*>@',
        ];
        $html = strip_tags(preg_replace($filters, '', $html));
        return str_word_count($html);
    }

    /**
     * @param DOMDocument $doc
     * @return int
     */
    private function getTitleLength(DOMDocument $doc): int {
        if ($doc->getElementsByTagName('title')->count() === 0) {
            return 0;
        }

        if ($doc->getElementsByTagName('title')->item(0)->childNodes->count() === 0) {
            return strlen($doc->getElementsByTagName('title')->item(0)->nodeValue);
        }

        return strlen($doc->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue);
    }
}
