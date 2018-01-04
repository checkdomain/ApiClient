# The checkdomain API client for php

A PHP client for the [Checkdomain Rest API](https://developer.checkdomain.de/).

Visit [Getting Started with Checkdomain API](https://developer.checkdomain.de/guide/#first-steps-and-setup) to get a extended version of instructions.

## Installation
##### Via Composer
```
{
    "require" : {
        "checkdomain/api-client" : "^1.0.0"
    }
}
```
## Example
```
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
 
### $response ###
array(4) {
  ["code"]=>
  int(201)
  ["location"]=>
  string(46) "/v1/domains/{domains}/nameservers/records/{new-record}"
  ["message"]=>
  NULL
  ["body"]=>
  NULL
}
```
For more examples look at the example folder in the project base dir.

## Semantic Versioning 2.0.0

We follow the rules of Semantic Versioning 2.0.0 .
### Summary
Given a version number MAJOR.MINOR.PATCH, increment the:

MAJOR version when you make incompatible API changes,
MINOR version when you add functionality in a backwards-compatible manner, and
PATCH version when you make backwards-compatible bug fixes.
Additional labels for pre-release and build metadata are available as extensions to the MAJOR.MINOR.PATCH format.

For more informations visit [Semantic Versioning](https://semver.org/).

## License

Copyright (c) 2017 Checkdomain GmbH, This is Free Software distributed under the MIT license.
