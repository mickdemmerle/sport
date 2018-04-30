<?php

namespace Sport\Bundle\AppSecurityBundle\Controller;

use Sport\Bundle\AppSecurityBundle\Controller\Helper\SecurityHelper;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sport\Bundle\AppSecurityBundle\Controller\ResettingController as FOSResettingController;

class ResettingController extends Controller
{
    use SecurityHelper;

    /**
     * @Route("/resetting/request/", name="resetting_request_override")
     * @param Request $request
     *
     * @return Response
     */
    public function requestAction(Request $request)
    {
        $isLogged = $this->redirectIfUserLogged();
        if ($isLogged !== false) {
            return $isLogged;
        }

        /** @var FOSResettingController $FOSResettingController */
        $FOSResettingController = $this->get('fos_user.resetting.controller');

        return $FOSResettingController->requestAction($request);
    }
}
