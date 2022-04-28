<?php

namespace App\Services;

interface CrawlerInterface
{
    public function crawl(string $url): self;
}
