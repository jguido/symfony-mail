<?php


namespace Tests\AppBundle\Service;


use AppBundle\Service\MailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\TemplateNameParserInterface;
use Tools\DataBuilder;
use Symfony\Bridge\Twig\TwigEngine;

class MailServiceTest extends \PHPUnit_Framework_TestCase
{
    use DataBuilder;

    public function testSendMailShouldSucceed()
    {
        $user = self::buildUser();
        $mailConfig = self::buildMailConfig();

        $request = new Request();
        $body = array(
            "config" => $mailConfig->getName(),
            "user" => $user->getEmail(),
            "title" => "Hello test",
            "recipients" => self::buildRecipientsSet(500),
            "lang" => "fr",
            "view" => "test",
            "reportTo" => "report@mailsersymfony.gt"
        );
        foreach ($body as $key => $value) {
            $request->request->add([$key => $value]);
        }

        $service = new MailService($this->getTwig(), 'testfrom@mailsersymfony.gt', 'testreport@mailsersymfony.gt');

        $service->sendMail($mailConfig, $request);
    }

    public function testSendBodyMailShouldSucceed()
    {
        $user = self::buildUser();
        $mailConfig = self::buildMailConfig();

        $request = new Request();
        $body = [
            "user" => $user->getEmail(),
            "config" => $mailConfig->getName().'321',
            "recipients" => self::buildRecipientsSet(500),
            "title" => "Hello test",
            "message" => "<!DOCTYPE html><html><head><title>Hello</title></head><body><h1>Hello world!</h1></body></html>",
            "lang" => "fr",
            "reportTo" => "report@mailsersymfony.gt"
        ];
        foreach ($body as $key => $value) {
            $request->request->add([$key => $value]);
        }

        $service = new MailService($this->getTwig(), 'testfrom@mailsersymfony.gt', 'testreport@mailsersymfony.gt');

        $service->sendBodyMail($mailConfig, $request);
    }

    protected function getTwig()
    {
        $twig = new \Twig_Environment(new \Twig_Loader_Array(array(
            'index' => 'foo',
            'error' => '{{ foo }',
        )));
        $parser = self::createMock(TemplateNameParserInterface::class);

        return new TwigEngine($twig, $parser);
    }
}