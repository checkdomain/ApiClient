<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// new instance of api client
$client = new \ApiClient\Client(
    'v1',
'yourToken'
);

//  update a single nameserver record
$response = $client->patch('domains/{domain}/nameservers/records/{record}', [
    'name' => 'zickzacke',
    'value' => '172.0.0.1',
    'ttl' => 180,
    'priority' => 0,
    'type' => 'A',
]);

var_dump($response);

