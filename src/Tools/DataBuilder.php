<?php


namespace Tools;


use AppBundle\Entity\MailConfig;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

trait DataBuilder
{

    protected function bootstrap(EntityManagerInterface $em)
    {
        foreach (range(1, 10) as $i) {
            $user = new User();
            $user->setUsername('user'.$i);
            $user->setEmail('user'.$i.'@testtesttestmailconfig'.'gt'.$i);
            $user->setPlainPassword('password'.$i);
            $user->setRoles(array('ROLE_ADMIN'));
            $user->setApikey('apikey'.$i);
            $em->persist($user);
        }

        $mailConfig = new MailConfig();
        $mailConfig->setHost('127.0.0.1');
        $mailConfig->setPort('25');
        $mailConfig->setName('test-config');
        $mailConfig->setUsername('username');
        $mailConfig->setPassword('password');
        $em->persist($mailConfig);

        $em->flush();
    }

    protected function getAUser(EntityManagerInterface $em)
    {
        return $em->getRepository('AppBundle:User')->findOneBy(array('username' => 'user1'));
    }

    protected function getMailConfig(EntityManagerInterface $em)
    {
        return $em->getRepository('AppBundle:MailConfig')->findOneBy(array('name' => 'test-config'));
    }
}
