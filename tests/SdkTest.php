<?php
/**
 * @author chenfang<crossfire1103@gmail.com>
 */
namespace Yoozoo\Protoapi\Tests;

use Yoozoo\Protoapi;

class Request implements Protoapi\Message
{
    public function validate() {}
    public function init(array $arr) {}
    public function to_array() {
        return [];
    }
}

class Response implements Protoapi\Message
{
    public function validate() {}
    public function init(array $arr) {}
    public function to_array() {
        return [];
    }
}

class ClientTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Yoozoo\Protoapi\httpClient;
     */
    protected $client;

    public function setUp()
    {
        $this->client = new Protoapi\httpClient(
            [
                'base_uri' => "testurl",
                'timeout' => 30,
            ]
        );
    }

    public function testCallApi()
    {
        $request = new Request();
        $handler = function($response, $bizError, $comError) {
            var_dump($response, $bizError, $comError);
        };
        $body = $this->client->callApi($request, "post", "getservice", $handler);
    }
}
