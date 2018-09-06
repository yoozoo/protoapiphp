<?php
/**
 * @see  https://github.com/yoozoo/protoapiphp
 * @author  chenfang<crossfire1103@gmail.com>
 */

namespace Yoozoo\Protoapi;

use Exception;
use GuzzleHttp\Client;

interface Message
{
    public function validate();
    public function init(array $arr);
    public function to_array();
}

class httpClient extends Client
{
    /**
     * call api, handle error, return response
     *
     * @param Message $req
     * @param String $method
     * @param String $uri
     * @param function $handler function($response, $bizerror, $common) create response oject or throw biz error exception
     * @return Message $result
     */
    public function callApi(Message $req, $method, $uri, $handler)
    {
        // check handle, php before 5.4 do not support Type Hinting of callable
        if (!is_callable($handler)) {
            throw new Exception("Can not find response handle.");
        }

        $data = [
            'json' => (object)$req->to_array(),
            'http_errors' => false,
        ];
        $response = $this->request($method, $uri, $data);
        $rawContent = $response->getBody()->getContents();
        $content = json_decode($rawContent, true);

        $statusCode = $response->getStatusCode();
        switch ($statusCode) {
            case 200:
                // happy path
                if (isset($content)) {
                    return $handler($content, "", "");
                } else {
                    throw new Exception("Cannot find response body: " . $rawContent);
                }
                break;
            case 400:
                // biz error
                if (isset($content)) {
                    return $handler("", $content, "");
                }
                throw new Exception("Cannot find Biz Error body: " . $rawContent);
                break;
            case 420:
                // common error
                if (isset($content)) {
                    return $handler("", "", $content);
                }
                throw new Exception("Cannot find Common Error body: " . $rawContent);
                break;
            case 500:
                // internal error
                throw new InternalServerErrorException("Internal server error: " . $rawContent);
                break;
        }
    }
}
