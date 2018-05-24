<?php

namespace Sport\Bundle\ClientBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{
    /**
     * @Route("/profile", name="dashboard_profile")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@ClientBundle/Profile/index.html.twig', []);
    }
}
