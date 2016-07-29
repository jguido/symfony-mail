<?php


namespace AppBundle\Model;


interface MailDataInterface
{
    /**
     * @return string
     */
    public function getFrom();

    /**
     * @return array
     */
    public function getRecipients();

    /**
     * @return string
     */
    public function getLang();

    /**
     * @return string
     */
    public function getReportTo();

    /**
     * @return array
     */
    public function getExtraData();

    /**
     * @return string
     */
    public function getMessage();

    /**
     * @return bool
     */
    public function hasMessageToBeBuilt();
}