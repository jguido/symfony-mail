<?php
/**
 * Created by PhpStorm.
 * User: dj3
 * Date: 04/05/16
 * Time: 15:17
 */

namespace Tools;


trait RequestBuilder
{
    static $GET = 'GET';
    static $PUT = 'PUT';
    static $POST = 'POST';
    static $DELETE = 'DELETE';

    private $method;
    private $headers;
    private $body;

    protected function withMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    protected function withHeaders(array $headers)
    {
        $this->headers = $headers;

        return $this;
    }

    protected function withBody(array $body = array())
    {
        $this->body = json_encode($body);

        return $this;
    }

}