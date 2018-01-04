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
 * Example: How to get a single record
 *
 * Replace {domains} and {records} with identifier
 *
 * For further informations please visit
 * @see https://developer.checkdomain.de/reference/v1/domains/%7Bdomain%7D/nameservers/records/
 */
$response = $client->get('domains/{domains}/nameservers/records/{records}');
var_dump($response);


/**
 * Example: How to get all records
 *
 * Replace {domains} with identifier
 *
 * For further informations please visit
 * @see https://developer.checkdomain.de/reference/v1/domains/%7Bdomain%7D/nameservers/records/
 */
$response = $client->get('domains/{domains}/nameservers/records');
var_dump($response);


/**
 * Example: How to get all records matches filter criteria
 *
 * Replace {domains} with identifier
 *
 * For further informations please visit
 * @see https://developer.checkdomain.de/reference/v1/domains/%7Bdomain%7D/nameservers/records/
 */
$filter = [
    'tld' => 'de'   // Get only results with TOP-LEVEL-DOMAIN "de"
];

$response = $client->get('articles', $filter);
var_dump($response);

