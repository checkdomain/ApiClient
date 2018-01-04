<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

/**
 * Create a new api-client instance
 *
 * Replace {yourToken} with your secret token
 *
 * For further informations please visit
 * @see https://developer.checkdomain.de/guide/#1-registration-for-api-access
 */
$client = new \ApiClient\Client(
    'v1',
    '{yourToken}'
);

/**
 * Example: How to create a new nameserver record
 *
 * Replace {domains} with identifier
 *
 * For further informations please visit
 * @see https://developer.checkdomain.de/reference/v1/domains/%7Bdomain%7D/nameservers/records/
 */
$response = $client->post('domains/{domains}/nameservers/records',  [
    'name' => '@',
    'value' => '172.0.0.1',
    'ttl' => 180,
    'priority' => 0,
    'type' => 'A',
]);
var_dump($response);
