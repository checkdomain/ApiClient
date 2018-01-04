<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// new instance of api client
$client = new \ApiClient\Client(
    'v1',
    'yourToken'
);

// delete single record
$response = $client->delete('domains/{domain}/nameservers/records/{records}');

var_dump($response);
