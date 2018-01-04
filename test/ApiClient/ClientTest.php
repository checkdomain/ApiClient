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

    const GET_OK_FIX = "getSuccess.http";
    const POST_OK_FIX = "postSuccess.http";
    const POST_ERROR_FIX = 'postError.http';
    const POST_ERROR_VALID_FIX =  "postValidationError.http";

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
        $result = $this->getProtectedMethod($this->client, 'getHeader', ['token']);

        $this->assertEquals('Bearer '.self::TOKEN, $result['Authorization']);
        $this->assertEquals('application/json', $result['Accept']);
        $this->assertEquals(2, count($result));
    }

    /**
     * Test version base path
     */
    public function testGetBasePath()
    {
        $result = $this->getProtectedMethod($this->client, 'getBasePath', ['version']);

        $this->assertEquals(self::BASE_URI.self::VERSION.'/', $result);
    }

    /**
     * Test parameter structure
     */
    public function testParams()
    {
        $this->getProtectedMethod($this->client, 'request', [
           'HTTP_METHOD', 'URL', ['key' => "value"], ['key' => 'value']
        ]);

        $options = $this->getProtectedProperty($this->client,'guzzleOptions');
        $this->assertEquals('value', $options['query']['key']);
        $this->assertEquals('{"key":"value"}',$options['body']);
    }

    /**
     * Test http GET success
     */
    public function testGetRequest()
    {
        $this->setGuzzleMockHandler(self::GET_OK_FIX);

        $response = $this->client->get('domains');

        $this->assertEquals(200, $response['code']);
        $this->assertEquals(null, $response['location']);
        $this->assertNotEmpty($response['body']);

        $content = file_get_contents(__DIR__ . "/../fixtures/".self::GET_OK_FIX);
        $pos = strpos($content, "{");
        $body = json_decode(substr($content, $pos, strlen($content)-$pos));

        $this->assertEquals(
            $response['body'],
            $body
        );
    }

    /**
     *  Test http POST success
     */
    public function testPostSuccess()
    {
        $this->setGuzzleMockHandler(self::POST_OK_FIX);

        $response = $this->client->post('domains/123/nameservers/records',[
            'name' => '@',
            'value' => '172.0.0.1',
            'ttl' => 180,
            'priority' => 0,
            'type' => 'A',
        ]);

        $this->assertEquals(201, $response['code']);
        $this->assertEquals('/v1/domains/461499/nameservers/records/3456724', $response['location']);
        $this->assertEmpty($response['body']);
    }

    /**
     *  Test http POST error
     */
    public function testPostError()
    {
        $this->setGuzzleMockHandler(self::POST_ERROR_FIX);

        $response = $this->client->post('domains/123/nameservers/records',[
            'name' => '@',
            'value' => '172.0.0.1',
            'ttl' => 180,
            'priority' => 0,
            'type' => 'A',
        ]);

        $this->assertEquals(500, $response['code']);
        $this->assertEquals('Nameserver update failed', $response['message']);
        $this->assertEmpty($response['body']);
        $this->assertEmpty($response['location']);
    }

    /**
     *  Test http POST validation failure
     */
    public function testPostValidation()
    {
        $this->setGuzzleMockHandler(self::POST_ERROR_VALID_FIX);

        $response = $this->client->post('domains/123/nameservers/records', [
            'name' => '@',
            'value' => '172.0.0.1',
            'ttl' => 180,
            'priority' => 999,
            'type' => 'A',
        ]);

        $this->assertEquals(400, $response['code']);
        $this->assertNotEmpty($response['body']);

        $content = file_get_contents(__DIR__ . "/../fixtures/".self::POST_ERROR_VALID_FIX);
        $pos = strpos($content, "{");
        $body = json_decode(substr($content, $pos, strlen($content)-$pos));

        $this->assertEquals(
            $response['body'],
            $body->errors
        );
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
    private function getProtectedMethod(Client $object, $methodName, $args)
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
