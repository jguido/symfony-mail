<?php

namespace Tools;


trait RequestBuilder
{
    public static $GET = 'GET';
    public static $PUT = 'PUT';
    public static $POST = 'POST';
    public static $DELETE = 'DELETE';

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
