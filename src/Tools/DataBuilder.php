<?php


namespace Tools;


use AppBundle\Entity\MailConfig;
use AppBundle\Entity\User;

trait DataBuilder
{

    protected function bootstrap()
    {
        foreach (range(1, 10) as $i) {
            $user = new User();
            $user->setUsername('user'.$i);
            $user->setEmail('user'.$i.'@testtesttestmailconfig'.'gt'.$i);
            $user->setPlainPassword('password'.$i);
            $user->setRoles(array('ROLE_ADMIN'));
            $user->setApikey('apikey'.$i);
            $this->entityManager->persist($user);
        }

        $mailConfig = new MailConfig();
        $mailConfig->setHost('127.0.0.1');
        $mailConfig->setPort('25');
        $mailConfig->setName('test-config');
        $mailConfig->setUsername('username');
        $mailConfig->setPassword('password');
        $this->entityManager->persist($mailConfig);

        $this->entityManager->flush();
    }

    /**
     * @return User
     */
    protected function getAUser()
    {
        return $this->entityManager->getRepository('AppBundle:User')->findOneBy(array('username' => 'user1'));
    }

    /**
     * @return MailConfig
     */
    protected function getMailConfig()
    {
        return $this->entityManager->getRepository('AppBundle:MailConfig')->findOneBy(array('name' => 'test-config'));
    }
}
