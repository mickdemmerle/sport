<?php

namespace Sport\Bundle\AppSecurityBundle\Controller;

use Sport\Bundle\AppSecurityBundle\Controller\Helper\SecurityHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\UserBundle\Controller\SecurityController as FOSSecurityController;

class SecurityController extends Controller
{
    use SecurityHelper;

    /**
     * @Route("/login", name="login_override")
     * @param Request $request
     *
     * @return Response
     */
    public function loginAction(Request $request)
    {
        $isLogged = $this->redirectIfUserLogged();
        if ($isLogged !== false) {
            return $isLogged;
        }

        /** @var FOSSecurityController $FOSSecurityRegister */
        $FOSSecurityRegister = $this->get('fos_user.security.controller');

        return $FOSSecurityRegister->loginAction($request);
    }
}
