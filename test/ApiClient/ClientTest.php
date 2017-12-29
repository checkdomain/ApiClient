<?php

use PHPUnit\Framework\TestCase;
use ApiClient\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

/**
 * @covers Client
 */
final class ClientTest extends TestCase
{
    const TOKEN = "token";
    const VERSION = "version";
    const BASE_URI = "https://api.checkdomain.de/";

    const GET_REQUEST_FIXTURE = "getResponse.http";
    const POST_REQUEST_FIXTURE = "postResponse.http";

    /**
     * @var Client
     */
    private $client;

    /**
     * ClientTest constructor.
     *
     * @param null   $name
     * @param array  $data
     * @param string $dataName
     */
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        $this->client = new Client(self::VERSION, self::TOKEN);
    }

    /**
     * Test authorization header
     */
    public function testGetHeader()
    {
        $result = $this->getProtectedMethode($this->client, 'getHeader', ['token']);

        $this->assertEquals('Bearer '.self::TOKEN, $result['Authorization']);
        $this->assertEquals('application/json', $result['Accept']);
        $this->assertEquals(2, count($result));
    }

    /**
     * Test version base path
     */
    public function testGetBasePath()
    {
        $result = $this->getProtectedMethode($this->client, 'getBasePath', ['version']);

        $this->assertEquals(self::BASE_URI.self::VERSION.'/', $result);
    }

    /**
     * Test parameter structure
     */
    public function testParams()
    {
        $this->client->request('METHODE','URL',
            ['key' => "value"],
            ['key' => 'value']
        );

        $options = $this->getProtectedProperty($this->client,'guzzleOptions');
        $this->assertEquals('value',$options['query']['key']);
        $this->assertEquals('{"key":"value"}',$options['body']);
    }

    /**
     * Test Http GET Success
     */
    public function testGetRequest()
    {
        $this->setGuzzleMockHandler(self::GET_REQUEST_FIXTURE);

        $response = $this->client->request('METHODE','URL');

        $this->assertEquals(200, $response['code']);
        $this->assertEquals(null, $response['location']);
        $this->assertNotEmpty($response['response']);

        $content = file_get_contents(__DIR__ . "/../fixtures/".self::GET_REQUEST_FIXTURE);
        $pos = strpos($content, "{");
        $body = substr($content, $pos, strlen($content)-$pos);

        $this->assertEquals(
            $response['response'],
            json_decode($body)
        );
    }

    /**
     *  Test Http POST Success
     */
    public function testPostRequest()
    {
        $this->setGuzzleMockHandler(self::POST_REQUEST_FIXTURE);

        $response = $this->client->request('METHODE','URL');

        $this->assertEquals(201, $response['code']);
        $this->assertEquals('/v1/domains/461499/nameservers/records/3456724', $response['location']);
        $this->assertEmpty($response['response']);
    }

    /**
     * Initiates new Client with GuzzleRequest MockHandler
     *
     * @param string $fixture
     */
    private function setGuzzleMockHandler($fixture)
    {
        $guzzleMockHandler = new MockHandler();
        $guzzleMockHandler->append(
            GuzzleHttp\Psr7\parse_response(
                file_get_contents(__DIR__ . "/../fixtures/".$fixture)
            )
        );

        $handler = HandlerStack::create($guzzleMockHandler);

        $this->client = new Client(self::VERSION, self::TOKEN, [
            'handler' => $handler
        ]);
    }

    /**
     * Use reflection to test private or protected methodes
     *
     * @param Client $object
     * @param        $methodName
     * @param        $args
     *
     * @return mixed
     */
    private function getProtectedMethode(Client $object, $methodName, $args)
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        return $method->invokeArgs($object, $args);
    }

    /**
     * Get values from private properties
     *
     * @param $object
     * @param $property
     *
     * @return mixed
     */
    private function getProtectedProperty($object, $property){
        $reflection = new \ReflectionClass(get_class($object));
        $prop = $reflection->getProperty($property);
        $prop->setAccessible(true);
        return $prop->getValue($object);
    }
}
