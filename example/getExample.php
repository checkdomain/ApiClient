<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// new instance of api client
$client = new \ApiClient\Client(
    'v1',
'yourToken'
);

// get a single record
$response = $client->get('domains/{domain}/nameservers/records/{records}');

var_dump($response);

// get all records for specific domain
$response = $client->get('domains/{domain}/nameservers/records');

var_dump($response);

// get all articles match filter criteria
$filter = [
    'limit' => 10,  // max. 10 results per page
    'page' => 2,    // get results from page 2
    'tld' => 'de'   // TOP-LEVEL-DOMAIN "de"
];

$response = $client->get('articles', $filter);

var_dump($response);

