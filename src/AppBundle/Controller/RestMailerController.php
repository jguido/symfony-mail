<?php

namespace AppBundle\Controller;

use AppBundle\Entity\MailConfig;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class RestController
 * @package AppBundle\Controller
 * @Route("/api")
 */
class RestMailerController extends Controller
{
    /**
     * @Route("/send-body-mail", name="rest_send_body_mail")
     * @Method("POST")
     */
    public function sendBodyMailAction(Request $request)
    {
        if (!$this->mergeAndValidateRequest($request)) {
            return $this->returnBadRequest();
        }

        $config = $this->get('doctrine.orm.default_entity_manager')->getRepository('AppBundle:MailConfig')->findOneBy(array('name' => $request->get('config')));
        if (!$config) {
            return $this->returnNotFoundResponse();
        }

        $from = $request->get('from', $this->get('service_container')->getParameter('default_from'));
        $title = $request->get('title', 'Message');
        $config = $this->get('doctrine.orm.default_entity_manager')->getRepository('AppBundle:MailConfig')->findOneBy(array('name' => $request->get('config')));
        $message = $request->get('message');
        $to = $request->get('to');
        $this->sendMail($config, $message, $from, $to, $title);

        return new Response('', Response::HTTP_OK, array('Content-Type' => 'application/json'));
    }

    /**
     * @param MailConfig $config
     * @param $message
     * @param $from
     * @param array $to
     * @param $title
     */
    private final function sendMail(MailConfig $config, $message, $from, array $to, $title)
    {
        $transport = Swift_SmtpTransport::newInstance($config->getHost(), $config->getPort())
            ->setUsername($config->getUsername())
            ->setPassword($config->getPassword());
        if ($config->getEncryption()) {
            $transport->setEncryption($config->getEncryption());
        }
        $mailer = Swift_Mailer::newInstance($transport);
        $message = Swift_Message::newInstance($title)
            ->setFrom($from)
            ->setBcc($to)
            ->setBody($message, 'text/html');

        $mailer->send($message);
    }

    /**
     * @Route("/send-mail", name="rest_send_mail")
     * @Method("POST")
     */
    public function sendMailAction(Request $request)
    {
        if (!$this->mergeAndValidateRequest($request)) {
            return $this->returnBadRequest();
        }

        $config = $this->get('doctrine.orm.default_entity_manager')->getRepository('AppBundle:MailConfig')->findOneBy(array('name' => $request->get('config')));
        if (!$config) {
            return $this->returnNotFoundResponse();
        }
        $this->get('service_mail')->sendMail($config, $request);

        return new Response('', Response::HTTP_OK, array('Content-Type' => 'application/json'));
    }

    /**
     * @param $body
     * @return Response
     */
    private final function returnBadRequest($body = '')
    {
        return new Response($body, Response::HTTP_BAD_REQUEST, array('Content-Type' => 'application/json'));
    }

    /**
     * @return Response
     */
    private final function returnNotFoundResponse()
    {
        return new Response('', Response::HTTP_NOT_FOUND, array('Content-Type' => 'application/json'));
    }

    /**
     * @param Request $request
     * @return bool
     */
    private final function mergeAndValidateRequest(Request &$request)
    {
        $content = json_decode($request->getContent(), true);
        foreach ($content as $key => $value) {
            $request->request->add(array($key => $value));
        }
        if (!$request->get('config') || !$request->get('view') || !is_array($request->get('recipients'))) {
            return false;
        }

        return true;
    }
}
