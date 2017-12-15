<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use ApiClient\Client;
use ApiClient\Model;

$client = new Client(
    'http://api-public.checkdomain.vm/v1/',
    'WnZwauTqHCh5NvD7KoHlLakuBagBnVExduqIP6+H12KTIkrFcBvx9uk4yILHPXtOttOreIk/iPFn8j64'
);

#$response = $client->domains(1)->nameserver()->records(1)->retrieve();


$request = new Model\Request\Domain\Nameserver\Record();
$request->setName("test")
    ->setType('A')
    ->setPriority(0)
    ->setTtl(180)
    ->setValue('192.168.0.1');

$response = $client->domains(1)->nameservers()->records()->create($request);

var_dump($response);

/*
$client->domains()->create($request);           // anlegen
$client->domains(1)->retrieve();                 // eine oder alle
$client->domains(1)->replace($request);                 // eine ersetzen
$client->domains(1)->update($request);                  // eine aktualisieren
$client->domains(1)->remove();                  // eine domain löschen

$client->domains('www.test.de')->check();

$client->domains('1')->autoRenewal()->create();
$client->domains('1')->autoRenewal()->remove();

$client->domains('1')->create()->transfer();
$client->domains('1')->remove()->transfer();

// unter resourcen
$client->domains(1)->contracts(1)->retrieve();

$client->domain(1)->nameserver()->record()->retrieve();
*/
