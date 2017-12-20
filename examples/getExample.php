<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// new instance of api client
$client = new \ApiClient\Client(
    'v1',
''
);

//  Request all available articles with limit 5
#$response = $client->request($client::HTTP_GET,'domains/461499/nameservers/records/3451620');

#var_dump($response);
#exit;

//  Request all available articles with limit 5
#$response = $client->request($client::HTTP_POST,'domains/461499/nameservers/records', null, [
#    'name' => 'zickzack',
#    'value' => '172.0.0.1',
#    'ttl' => 180,
#    'priority' => 0,
#    'type' => 'A',
#]);

#var_dump($response);

$response = $client->request($client::HTTP_PATCH,'domains/461499/nameservers/records/3451620', null, [
    'name' => 'zickzacke',
    'value' => '172.0.0.1',
    'ttl' => 180,
    'priority' => 0,
    'type' => 'A',
]);

var_dump($response);

