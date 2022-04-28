<div x-data="Crawler()">

    <div class="flex justify-center flex-col my-4 gap-6">
        <input wire:model="url" type="text" name="url" id="url" class="shadow-sm focus:ring-black focus:border-black block sm:text-sm border-gray-300 rounded-md bg-gray-100 text-gray-600 w-60 text-center mx-auto mb-4" readonly/>

        <div class="w-auto flex items-center justify-center w-full">
            <button wire:loading.remove @click="startCrawling()" type="button" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Crawl Site!</button>
            <svg wire:loading width="45" height="45" viewBox="0 0 45 45" xmlns="http://www.w3.org/2000/svg" stroke="#000"><g fill="none" fill-rule="evenodd" transform="translate(1 1)" stroke-width="2"><circle cx="22" cy="22" r="6" stroke-opacity="0"><animate attributeName="r" begin="1.5s" dur="3s" values="6;22" calcMode="linear" repeatCount="indefinite" /><animate attributeName="stroke-opacity" begin="1.5s" dur="3s" values="1;0" calcMode="linear" repeatCount="indefinite" /><animate attributeName="stroke-width" begin="1.5s" dur="3s" values="2;0" calcMode="linear" repeatCount="indefinite" /></circle><circle cx="22" cy="22" r="6" stroke-opacity="0"><animate attributeName="r" begin="3s" dur="3s" values="6;22" calcMode="linear" repeatCount="indefinite" /><animate attributeName="stroke-opacity" begin="3s" dur="3s" values="1;0" calcMode="linear" repeatCount="indefinite" /><animate attributeName="stroke-width" begin="3s" dur="3s" values="2;0" calcMode="linear" repeatCount="indefinite" /></circle><circle cx="22" cy="22" r="8"><animate attributeName="r" begin="0s" dur="1.5s" values="6;1;2;3;4;5;6" calcMode="linear" repeatCount="indefinite" /></circle></g></svg>
        </div>

        <hr x-show="crawled" x-cloak/>

        <div x-show="crawled" x-cloak>
            <div><strong class="mr-4">Number of pages crawled:</strong><span x-text="data.number_pages_crawled"></span></div>
            <div><strong class="mr-4">Number of a unique images:</strong><span x-text="data.number_unique_images"></span></div>
            <div><strong class="mr-4">Number of unique internal links:</strong><span x-text="data.number_unique_internal_links"></span></div>
            <div><strong class="mr-4">Number of unique external links:</strong><span x-text="data.number_unique_external_links"></span></div>
            <div><strong class="mr-4">Average page load in seconds:</strong><span x-text="data.avg_page_load + 's'"></span></div>
            <div><strong class="mr-4">Average word count:</strong><span x-text="data.avg_word_count"></span></div>
            <div><strong class="mr-4">Average title length:</strong><span x-text="data.avg_title_length"></span></div>
        </div>

        <hr x-show="crawled" x-cloak/>

        <div x-show="crawled" x-cloak>
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="mt-8 flex flex-col">
                    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Url</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status Code</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    <template x-for="page_crawled in data.pages_crawled">
                                        <tr>
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6" x-text="page_crawled.url"></td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500" x-text="page_crawled.status"></td>
                                        </tr>
                                    </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <script>
        function Crawler() {
            return {
                url: @entangle('url'),
                data: @entangle('result'),
                crawled: @entangle('crawled'),

                startCrawling() {
                    this.$wire.startCrawling();
                }
            }
        }
    </script>

</div>
