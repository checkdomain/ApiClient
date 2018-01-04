<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// new instance of api client
$client = new \ApiClient\Client(
    'v1',
    'yourToken'
);

// replace all nameserver records for your domain
$response = $client->put('domains/{domain}/nameservers/records',  [
    [
        'name' => '@',
        'value' => '172.0.0.88',
        'ttl' => 180,
        'priority' => 0,
        'type' => 'A',
    ],[
        'name' => '@',
        'value' => '172.0.0.99',
        'ttl' => 180,
        'priority' => 0,
        'type' => 'A',
    ]
]);

var_dump($response);

// replace a single nameserver record
$response = $client->put('domains/{domain}/nameservers/records/{record}', [
    'name' => '@',
    'value' => '172.0.0.88',
    'ttl' => 180,
    'priority' => 0,
    'type' => 'A',
]);

var_dump($response);
