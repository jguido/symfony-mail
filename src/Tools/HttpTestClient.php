<?php

namespace Tools;

trait HttpTestClient
{
    use RequestBuilder;

    public function request($uri)
    {
        if (!$this->method || !$this->headers || !$this->body) {
            throw new \Exception("Before calling this method, please call method, header and body methods");
        }

        return $this->client->request($this->method, $uri, array(), array(), $this->headers, $this->body);
    }
}