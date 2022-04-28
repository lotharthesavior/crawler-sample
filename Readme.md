
# Crawler Sample

This is built using:

- laravel 9.2
- livewire 2.10
- alpine 2.8
- tailwind 2.2

This application is a simple crawler to retrieve and parse remote HTML.

There are 2 main classes: to do the job:

- `App\Http\Livewire\Crawler.php`, the Livewire component that handles the interation between frontend and backend.
- `App\Services\Crawler`, the service responsible for the crawling.

## Usage

**Step 1**

With composer installed in the environment, execute:

```shell
composer install
```

**Step 2**

With npm installed in the environment, execute:

```shell
npm install && npm run prod
```

**Step 3**

Here you just add the url for your crawler at the config:

```
URL_FOR_CRAWLER='https://my-url.com'
```

**Step 4**

Once you have the webserver running you can access the correspondent page in the browser.

## Tests

Execute tests:

```shell
./vendor/bin/phpunit
```

There are 2 tests present:

1. Unit test for the crawler service
2. Feature test for the livewire component

