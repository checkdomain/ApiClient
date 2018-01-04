<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// new instance of api client
$client = new \ApiClient\Client(
    'v1',
'your token'
);

// get single record
$response = $client->get('domains/111/nameservers');

var_dump($response);
/*
// get all records for specific domain
$response = $client->request($client::HTTP_GET,'domains/{domain}/nameservers/records');

var_dump($response);

// get all articles match filter criteria
$filter = [
    'limit' => 10,  // max. 10 results per page
    'page' => 2,    // get results from page 2
    'tld' => 'de'   // TOP-LEVEL-DOMAIN "de"
];

$response = $client->request($client::HTTP_GET,'articles', $filter);

var_dump($response);
*/
