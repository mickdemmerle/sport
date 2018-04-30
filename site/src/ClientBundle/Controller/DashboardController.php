<?php

namespace Sport\Bundle\ClientBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    /**
     * @Route("/", name="dashboard_homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('@ClientBundle/Homepage/index.html.twig', []);
    }
}
