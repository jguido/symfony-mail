<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/admin/logout", name="logout")
     */
    public function logoutAction(Request $request)
    {
        $this->get('security.token_storage')->setToken(null);
        $this->get('session')->invalidate();

        return $this->redirect('/admin');

    }

    /**
     * @Route("/admin/login", name="login")
     */
    public function loginAction()
    {
    }
    /**
     * @Route("/admin/login_check", name="login_check")
     */
    public function loginCheckAction()
    {

    }
}
