<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

$client = new \ApiClient\Client(
''
);

$response = $client->request('GET','articles', [
    'limit' => 3,
]);

var_dump($response);

