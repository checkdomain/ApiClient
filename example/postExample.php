<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// new instance of api client
$client = new \ApiClient\Client(
    'v1',
    'yourToken'
);

//  Create a new nameserver record
$response = $client->request($client::HTTP_POST,'/domains/{domain}/nameservers/records', null, [
    'name' => '@',
    'value' => '172.0.0.1',
    'ttl' => 180,
    'priority' => 1,
    'type' => 'A',
]);

var_dump($response);
