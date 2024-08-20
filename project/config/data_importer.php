<?php

return [
    'entity_name' => env('DATA_IMPORTER_ENTITY_NAME', 'App\Entities\Customer'),
    'data_filters' => [
        'nat' => env('DATA_IMPORTER_DEFAULT_FILTER', 'AU'),
        'results' => env('DATA_IMPORTER_DEFAULT_COUNT', 100)
    ],
    'api_data_url' =>env('DATA_IMPORTER_API_DATA_URL', 'https://randomuser.me/api'),
];
