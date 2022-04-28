<?php

namespace Tests\Feature;

use App\Http\Livewire\Crawler;
use Livewire\Livewire;
use Tests\TestCase;

class CrawlerLivewireTest extends TestCase
{
    public function test_get_words_count_right()
    {
        $this->mockCrawler();

        $result = Livewire::test(Crawler::class)
            ->call('startCrawling')
            ->get('result');

        $this->assertEquals(6, $result["number_pages_crawled"]);
        $this->assertEquals(1, $result["number_unique_images"]);
        $this->assertEquals(8, $result["number_unique_internal_links"]);
        $this->assertEquals(1, $result["number_unique_external_links"]);
        $this->assertEquals(1, $result["avg_page_load"]);
        $this->assertEquals(25, $result["avg_title_length"]);
        $this->assertEquals(2, $result["avg_word_count"]);
    }
}
