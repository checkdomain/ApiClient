<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// new instance of api client
$client = new \ApiClient\Client(
    'v1',
    ''
);

//  Create a new nameserver record
$response = $client->post('domains/{domain}/nameservers/records',  [
    'name' => '@',
    'value' => '172.0.0.99',
    'ttl' => 180,
    'priority' => 0,
    'type' => 'A',
]);

var_dump($response);
