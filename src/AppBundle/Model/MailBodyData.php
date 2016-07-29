<?php


namespace AppBundle\Model;


class MailBodyData implements MailDataInterface
{

    /**
     * MailData constructor.
     * @param $from
     * @param array $recipients
     * @param $body
     * @param $lang
     * @param $reportTo
     * @param array $extraData
     * @throws \Exception
     */
    public function __construct($from, array $recipients, $body, $lang, $reportTo, array $extraData = null)
    {
        $args = array('from' => $from, 'recipients' => $recipients, 'message' => $body, 'lang' => $lang);
        if (!$this->checkArgs($args)) {
            throw new \Exception('Bad parameters');
        }
        $this->from = $from;
        $this->recipients    = $recipients;
        $this->body = $body;
        $this->lang = $lang;
        $this->reportTo = $reportTo;
        $this->extraData = $extraData;
    }

    /**
     * @param array $args
     * @return bool
     */
    private final function checkArgs(array $args)
    {
        $check[] = array_walk($args, function($v, $k){
            if (empty($v)) {
                return false;
            }

            return true;
        });

        return in_array(false, $check) ? false : true;
    }


    /**
     * @var string
     */
    private $from;

    /**
     * @var string
     */
    private $body;

    /**
     * @var array
     */
    private $recipients;

    /**
     * @var string
     */
    private $lang;

    /**
     * @var string
     */
    private $reportTo;

    /**
     * @var array
     */
    private $extraData;

    /**
     * @return string
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function getRecipients()
    {
        return $this->recipients;
    }

    /**
     * @return string
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * @return string
     */
    public function getReportTo()
    {
        return $this->reportTo;
    }

    /**
     * @return array
     */
    public function getExtraData()
    {
        return $this->extraData;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->body;
    }

    /**
     * @return bool
     */
    public function hasMessageToBeBuilt()
    {
        return false;
    }
}
