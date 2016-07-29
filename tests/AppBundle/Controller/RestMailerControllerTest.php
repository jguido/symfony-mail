<?php


namespace Tests\AppBundle\Controller;


use Tools\BaseTestCase;

class RestMailerControllerTest extends BaseTestCase
{
    public function testSendMailActionShouldSucceed()
    {
        $user = $this->getAUser();
        $mailConfig = $this->getMailConfig();
        $body = array(
            "config" => $mailConfig->getName(),
            "user" => $user->getEmail(),
            "recipients" => ["test@mailsersymfony.gt"],
            "lang" => "fr",
            "view" => "test",
            "reportTo" => "report@mailsersymfony.gt"
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

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
    }
    public function testSendMailActionShouldSucceedWithHugeRecipientList()
    {
        $user = $this->getAUser();
        $mailConfig = $this->getMailConfig();
        $body = array(
            "config" => $mailConfig->getName(),
            "user" => $user->getEmail(),
            "recipients" => $this->buildRecipientsSet(10000),
            "lang" => "fr",
            "view" => "test",
            "reportTo" => "report@mailsersymfony.gt"
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

        self::assertEquals(200, $this->client->getResponse()->getStatusCode());
    }


    public function testSendMailActionShouldFailBecauseBadMailConfigNameGiven()
    {
        $user = $this->getAUser();
        $mailConfig = $this->getMailConfig();
        $body = array(
            "config" => $mailConfig->getName().'321',
            "user" => $user->getEmail(),
            "title" => "Hello test",
            "recipients" => ["test@mailsersymfony.gt"],
            "lang" => "fr",
            "view" => "test",
            "reportTo" => "report@mailsersymfony.gt"
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

    public function testSendMailActionShouldFailBecauseMissingConfigParameter()
    {
        $user = $this->getAUser();
        $mailConfig = $this->getMailConfig();
        $body = array(
//            "config" => $mailConfig->getName(),
            "user" => $user->getEmail(),
            "title" => "Hello test",
            "recipients" => ["test@mailsersymfony.gt"],
            "lang" => "fr",
            "view" => "test",
            "reportTo" => "report@mailsersymfony.gt"
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

        self::assertEquals(400, $this->client->getResponse()->getStatusCode());
    }
    public function testSendMailActionShouldFailBecauseMissingToParameter()
    {
        $user = $this->getAUser();
        $mailConfig = $this->getMailConfig();
        $body = array(
            "config" => $mailConfig->getName(),
            "user" => $user->getEmail(),
            "title" => "Hello test",
//            "recipients" => ["test@mailsersymfony.gt"],
            "lang" => "fr",
            "view" => "test",
            "reportTo" => "report@mailsersymfony.gt"
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

        self::assertEquals(400, $this->client->getResponse()->getStatusCode());
    }
    public function testSendMailActionShouldFailBecauseMissingMessageParameter()
    {
        $user = $this->getAUser();
        $mailConfig = $this->getMailConfig();
        $body = array(
            "config" => $mailConfig->getName(),
            "user" => $user->getEmail(),
            "title" => "Hello test",
            "recipients" => ["test@mailsersymfony.gt"],
            "lang" => "fr",
//            "view" => "test",
            "reportTo" => "report@mailsersymfony.gt"
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

        self::assertEquals(400, $this->client->getResponse()->getStatusCode());
    }
}