<?php

namespace App\Http\Livewire;

use Illuminate\Support\Arr;
use Livewire\Component;
use Facades\App\Services\Crawler as CrawlerService;

class Crawler extends Component
{
    public bool $crawled = false;

    public array $result = [];

    public string $url = '';

    public function mount()
    {
        $this->url = env('URL_FOR_CRAWLER');
        $this->resetResult();
    }

    public function startCrawling(): array
    {
        $this->resetResult();

        $internalLinks = $this->processCrawling($this->url)->internalLinks;
        $links = Arr::random($internalLinks, min([5, count($internalLinks)]));

        foreach ($links as $link) {
            $this->processCrawling($this->url . $link);
        }

        $this->crawled = true;

        return $this->result;
    }

    private function processCrawling(string $url)
    {
        $crawler = CrawlerService::crawl($url);

        $this->result['pages_crawled'][] = ['url' => $url, 'status' => $crawler->statusCode];
        $this->result['number_pages_crawled']++;
        $this->result['number_unique_images'] = count($crawler->imagesSrcs);
        $this->result['number_unique_internal_links'] = count($crawler->internalLinks);
        $this->result['number_unique_external_links'] = count($crawler->externalLinks);
        $this->result['page_loads'][] = $crawler->executionTime;
        $this->result['avg_page_load'] = $this->getAvg($this->result['page_loads']);
        $this->result['title_lengths'][] = $crawler->titleLength;
        $this->result['avg_title_length'] = $this->getAvg($this->result['title_lengths']);
        $this->result['word_counts'][] = $crawler->wordsCount;
        $this->result['avg_word_count'] = $this->getAvg($this->result['word_counts']);

        return $crawler;
    }

    private function getAvg(array $collection)
    {
        return number_format(array_sum($collection) / count($collection), 2, '.', '');
    }

    private function resetResult(): void
    {
        $this->result = [
            'pages_crawled' => [],
            'number_pages_crawled' => 0,
            'number_unique_images' => 0,
            'number_unique_internal_links' => 0,
            'number_unique_external_links' => 0,
            'page_loads' => [],
            'avg_page_load' => 0,
            'title_lengths' => [],
            'avg_title_length' => 0,
            'word_counts' => [],
            'avg_word_count' => 0,
        ];
    }

    public function render()
    {
        return view('livewire.crawler');
    }
}
