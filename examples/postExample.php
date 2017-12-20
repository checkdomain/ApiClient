<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// new instance of api client
$client = new \ApiClient\Client(
    '',
    ''
);

//  Request all available articles with limit 5
$response = $client->request($client::HTTP_POST,'/domains/111/nameservers/records', null, [
    'name' => '@',
    'value' => '172.0.0.1',
    'ttl' => 180,
    'priority' => 1,
    'type' => 'A',
]);

var_dump($response);
