<?php


namespace Tools;


use AppBundle\Entity\MailConfig;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

trait DataBuilder
{
    /**
     * @var EntityManagerInterface
     */
    private $builderEntityManager;

    private function __construct(EntityManagerInterface $em)
    {
        $this->builderEntityManager = $em;
    }

    protected function bootstrap()
    {
        foreach (range(1, 10) as $i) {
            $user = new User();
            $user->setUsername('user'.$i);
            $user->setEmail('user'.$i.'@testtesttestmailconfig'.'gt'.$i);
            $user->setPlainPassword('password'.$i);
            $user->setRoles(array('ROLE_ADMIN'));
            $user->setApikey('apikey'.$i);
            $this->builderEntityManager->persist($user);
        }

        $mailConfig = new MailConfig();
        $mailConfig->setHost('127.0.0.1');
        $mailConfig->setPort('25');
        $mailConfig->setName('test-config');
        $mailConfig->setUsername('username');
        $mailConfig->setPassword('password');
        $this->builderEntityManager->persist($mailConfig);

        $this->builderEntityManager->flush();
    }

    protected function getAUser()
    {
        return $this->builderEntityManager->getRepository('AppBundle:User')->findOneBy(array('username' => 'user1'));
    }

    protected function getMailConfig()
    {
        return $this->builderEntityManager->getRepository('AppBundle:MailConfig')->findOneBy(array('name' => 'test-config'));
    }
}