<?php

namespace Tests;

use Facades\App\Services\Crawler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function mockCrawler()
    {
        $sampleHtml = <<<HTML
<!DOCTYPE html>
<html>
<head>
	<title>An HTML standard template</title>
	<meta charset="utf-8"  />
</head>
<body>
     <img src="/test.png"/>
     <a href="https://external.com/external"/>
     <a href="/local"/>
     <a href="/local2"/>
     <a href="/local3"/>
     <a href="/local4"/>
     <a href="/local5"/>
     <a href="/local6"/>
     <a href="/local7"/>
     <a href="/local8"/>
     <p>Content here</p>
</body>
</html>
HTML;

        Crawler::partialMock()
            ->shouldReceive('getPageContents')
            ->andReturnUsing(function() use ($sampleHtml) {
                sleep(1);
                return $sampleHtml;
            });
    }
}
