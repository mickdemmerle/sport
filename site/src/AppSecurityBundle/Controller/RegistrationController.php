<?php

namespace Sport\Bundle\AppSecurityBundle\Controller;

use Sport\Bundle\AppSecurityBundle\Controller\Helper\SecurityHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FOS\UserBundle\Controller\RegistrationController as FOSRegistrationController;

class RegistrationController extends Controller
{
    use SecurityHelper;

    /**
     * @Route("/register/", name="register_override")
     * @param Request $request
     *
     * @return Response
     */
    public function registerAction(Request $request)
    {
        $isLogged = $this->redirectIfUserLogged();
        if ($isLogged !== false) {
            return $isLogged;
        }

        /** @var FOSRegistrationController $FOSUserRegister */
        $FOSUserRegister = $this->get('fos_user.registration.controller');

        return $FOSUserRegister->registerAction($request);
    }
}
