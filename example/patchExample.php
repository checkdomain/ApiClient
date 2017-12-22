<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// new instance of api client
$client = new \ApiClient\Client(
    'v1',
'yourToken'
);

// Patch record with id 3451620 example
$response = $client->request($client::HTTP_PATCH,'domains/461499/nameservers/records/3451620', null, [
    'name' => 'zickzacke',
    'value' => '172.0.0.1',
    'ttl' => 180,
    'priority' => 0,
    'type' => 'A',
]);

var_dump($response);

