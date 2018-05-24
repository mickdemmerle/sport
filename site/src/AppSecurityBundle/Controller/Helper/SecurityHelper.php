<?php

namespace Sport\Bundle\AppSecurityBundle\Controller\Helper;

trait SecurityHelper {

    public function redirectIfUserLogged()
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {

            return $this->redirect($this->generateUrl('dashboard_homepage'));
        }

        return false;
    }
}