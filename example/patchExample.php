<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// new instance of api client
$client = new \ApiClient\Client(
    'v1',
'yourToken'
);

//  PATCH example, updates a single nameserver record
$response = $client->request($client::HTTP_PATCH,'domains/{domain}/nameservers/records/{record}', null, [
    'name' => 'zickzacke',
    'value' => '172.0.0.1',
    'ttl' => 180,
    'priority' => 0,
    'type' => 'A',
]);

var_dump($response);

