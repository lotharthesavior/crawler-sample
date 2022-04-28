<?php

namespace Tests\Feature;

use Facades\App\Services\Crawler;
use Tests\TestCase;

class CrawlerTest extends TestCase
{
    public function test_html_analysis()
    {
        $this->mockCrawler();

        $crawler = Crawler::crawl('https://sample.com');

        $this->assertEquals(2, $crawler->wordsCount);
        $this->assertEquals(1, $crawler->executionTime);
        $this->assertCount(1, $crawler->imagesSrcs);
        $this->assertCount(8, $crawler->internalLinks);
        $this->assertCount(1, $crawler->externalLinks);
        $this->assertEquals(2, $crawler->wordsCount);
        $this->assertEquals(25, $crawler->titleLength);
    }
}
