<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/admin/logout", name="logout")
     * @Method("GET")
     */
    public function logoutAction(Request $request)
    {
        $this->get('security.token_storage')->setToken(null);
        $this->get('session')->invalidate();

        return $this->redirect('/admin');

    }

    /**
     * @Route("/admin/login", name="login")
     * @Method("GET")
     */
    public function loginAction()
    {
    }
}
