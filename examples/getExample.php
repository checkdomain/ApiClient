<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// new instance of api client
$client = new \ApiClient\Client(
    '',
''
);

//  Request all available articles with limit 5
$response = $client->request($client::HTTP_GET,'articles', [
    'limit' => 5,
]);

var_dump($response);
