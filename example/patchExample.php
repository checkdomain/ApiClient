<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

// new instance of api client
$client = new \ApiClient\Client(
    'v1',
'yourToken'
);

//  update a single contact
$response = $client->patch('contacts/{contact}', [
    "first_name" => "Jane"
]);

var_dump($response);

