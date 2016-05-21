<?php


namespace Tests\AppBundle\Controller;


use Tools\BaseTestCase;

class RestMailerControllerTest extends BaseTestCase
{
    public function testSendMailActionShouldFailBecauseBadMailConfigNameGiven()
    {
        $user = $this->getAUser();
        $mailConfig = $this->getMailConfig();
        $body = array(
            "config" => $mailConfig->getName().'321',
            "from" => $user->getEmail(),
            "title" => "Hello test",
            "to" => ["test@mailsersymfony.gt"],
            "message" => "<!DOCTYPE html><html><head><title>Hello</title></head><body><h1>Hello world!</h1></body></html>"
        );

        $route = $this->client->getContainer()->get('router')->generate('rest_send_mail');
        $this
            ->withMethod(self::$POST)
            ->withHeaders(array(
                'HTTP_apikey' => $user->getApikey(),
                'CONTENT_TYPE' => 'application/json',
            ))
            ->withBody($body)
            ->request($route);

        self::assertEquals(500, $this->client->getResponse()->getStatusCode());
    }
    public function testSendMailActionShouldFailBecauseMissingConfigParameter()
    {
        $user = $this->getAUser();
        $mailConfig = $this->getMailConfig();
        $body = array(
//            "config" => $mailConfig->getName(),
            "from" => $user->getEmail(),
            "title" => "Hello test",
            "to" => ["test@mailsersymfony.gt"],
            "message" => "<!DOCTYPE html><html><head><title>Hello</title></head><body><h1>Hello world!</h1></body></html>"
        );

        $route = $this->client->getContainer()->get('router')->generate('rest_send_mail');
        $this
            ->withMethod(self::$POST)
            ->withHeaders(array(
                'HTTP_apikey' => $user->getApikey(),
                'CONTENT_TYPE' => 'application/json',
            ))
            ->withBody($body)
            ->request($route);

        self::assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
    public function testSendMailActionShouldFailBecauseMissingToParameter()
    {
        $user = $this->getAUser();
        $mailConfig = $this->getMailConfig();
        $body = array(
            "config" => $mailConfig->getName(),
            "from" => $user->getEmail(),
            "title" => "Hello test",
//            "to" => ["test@mailsersymfony.gt"],
            "message" => "<!DOCTYPE html><html><head><title>Hello</title></head><body><h1>Hello world!</h1></body></html>"
        );

        $route = $this->client->getContainer()->get('router')->generate('rest_send_mail');
        $this
            ->withMethod(self::$POST)
            ->withHeaders(array(
                'HTTP_apikey' => $user->getApikey(),
                'CONTENT_TYPE' => 'application/json',
            ))
            ->withBody($body)
            ->request($route);

        self::assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
    public function testSendMailActionShouldFailBecauseMissingMessageParameter()
    {
        $user = $this->getAUser();
        $mailConfig = $this->getMailConfig();
        $body = array(
            "config" => $mailConfig->getName(),
            "from" => $user->getEmail(),
            "title" => "Hello test",
            "to" => ["test@mailsersymfony.gt"],
//            "message" => "<!DOCTYPE html><html><head><title>Hello</title></head><body><h1>Hello world!</h1></body></html>"
        );

        $route = $this->client->getContainer()->get('router')->generate('rest_send_mail');
        $this
            ->withMethod(self::$POST)
            ->withHeaders(array(
                'HTTP_apikey' => $user->getApikey(),
                'CONTENT_TYPE' => 'application/json',
            ))
            ->withBody($body)
            ->request($route);

        self::assertEquals(404, $this->client->getResponse()->getStatusCode());
    }
}