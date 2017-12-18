<?php

require_once __DIR__ . '/../vendor/autoload.php'; // Autoload files using Composer autoload

use ApiClient\Client;
use ApiClient\Model;

$client = new Client(
    'http://api-public.checkdomain.vm/v1/',
    ''
);

# Record anlegen
$request = new Model\Request\Domain\Nameserver\Record();

#$request->setName("321test")
#    ->setType('A')
#    ->setPriority(0)
#    ->setTtl(180)
#    ->setValue('192.168.0.1');

# Record anlegen
#$response = $client->domains(111)->nameservers()->records()->create($request);
# Records ersetzen
#$response = $client->domains(111)->nameservers()->records()->replace($request);
# Record ersetzen
#$response = $client->domains(111)->nameservers()->records(3)->replace($request);

#Domains
# Alle Domains gefiltert
$filter = new Model\Request\Domain\DomainFilter();
$filter
    ->setLimit(1)
    ->setPage(2);

$response = $client->domains()->retrieve($filter);

#$client->articles()->retrieve();


# Eine Domain
#$response = $client->domains(111)->retrieve();

# Nameserver/Zone für eine Domain
#$response = $client->domains(111)->nameservers()->retrieve();


var_dump($response);
