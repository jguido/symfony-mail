<?php


namespace AppBundle\Service;


use AppBundle\Entity\MailConfig;
use AppBundle\Model\MailBodyData;
use AppBundle\Model\MailDataInterface;
use AppBundle\Model\MailViewData;
use AppBundle\Model\Recipient;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Templating\EngineInterface;
use Icicle\Coroutine\Coroutine;
use Icicle\Loop;

class MailService
{
    /**
     * @var EngineInterface
     */
    private $engine;
    /**
     * @var string
     */
    private $from;
    /**
     * @var string
     */
    private $reportTo;

    public function __construct(EngineInterface $engine, $from, $reportTo)
    {
        $this->engine = $engine;
        $this->from = $from;
        $this->reportTo = $reportTo;
    }

    /**
     * @param MailConfig $config
     * @param Request $request
     */
    public function sendMail(MailConfig $config, Request $request)
    {
        $from = $request->get('user', $this->from);
        $reportTo = $request->get('reportTo', $this->reportTo);
        $lang = $request->get('lang', 'en');
        $view = $request->get('view');
        $recipients = $request->get('recipients');
        $mailData = new MailViewData($from, $recipients, $view, $lang, $reportTo);

        new Coroutine($this->internalSendMail($config, $mailData));
    }

    /**
     * @param MailConfig $config
     * @param Request $request
     */
    public function sendBodyMail(MailConfig $config, Request $request)
    {
        $from = $request->get('user', $this->from);
        $reportTo = $request->get('reportTo', $this->reportTo);
        $lang = $request->get('lang', 'en');
        $body = $request->get('message');
        $recipients = $request->get('recipients');
        $mailData = new MailBodyData($from, $recipients, $body, $lang, $reportTo);

        new Coroutine($this->internalSendMail($config, $mailData, $request->get('title', 'body send')));
    }

    /**
     * @param MailConfig $config
     * @param MailDataInterface $mailData
     * @return \Generator
     */
    private final function internalSendMail(MailConfig $config, MailDataInterface $mailData, $title = null)
    {
        $transport = $this->buildTransport($config);

        $mailer = Swift_Mailer::newInstance($transport);
        $report = [];
        if ($mailData->hasMessageToBeBuilt()) {
            $body = $this->engine->render(':mails:'.$mailData->getMessage().'.html.twig', array(
                '_locale' => $mailData->getLang()
            ));
        } else {
            $body = $mailData->getMessage();
        }

        foreach ($mailData->getRecipients() as $recipient) {

            new Coroutine($this->messageGenerator($mailer, $mailData, $body, $recipient, $report));
        }
        $message = Swift_Message::newInstance('Title : '.$title)
            ->setFrom($mailData->getFrom())
            ->setBcc($mailData->getReportTo())
            ->setBody(implode("<br/>", $report), 'text/html');

        $mailer->send($message, $report);

        Loop\run();


        yield;
    }

    /**
     * @param MailConfig $config
     * @return Swift_SmtpTransport
     */
    private function buildTransport(MailConfig $config)
    {
        $transport = Swift_SmtpTransport::newInstance($config->getHost(), $config->getPort())
            ->setUsername($config->getUsername())
            ->setPassword($config->getPassword());
        if ($config->getEncryption()) {
            $transport->setEncryption($config->getEncryption());
        }

        return $transport;
    }

    /**
     * @param Swift_Mailer $mailer
     * @param MailDataInterface $mailData
     * @param $body
     * @param array $report
     * @return \Generator
     */
    private function messageGenerator(Swift_Mailer $mailer, MailDataInterface $mailData, $body, Recipient $recipient, array &$report)
    {

        $message = Swift_Message::newInstance('Title')
            ->setFrom($mailData->getFrom())
            ->setBcc($recipient->getEmail())
            ->setBody($body, 'text/html');

        $result = $mailer->send($message, $report);

        yield $result;
    }
}
