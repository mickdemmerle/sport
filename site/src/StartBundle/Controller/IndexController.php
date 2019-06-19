<?php

namespace Sport\Bundle\StartBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sport\Bundle\StartBundle\Controller\Helper\IndexHelper;
use Sport\Domain\Start\TrainingFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;

class IndexController extends Controller
{
    use IndexHelper;

    /**
     * @var TrainingFactory
     */
    private $trainingFactory;

    /**
     * @param TrainingFactory $trainingFactory
     */
    public function __construct(TrainingFactory $trainingFactory)
    {
        $this->trainingFactory = $trainingFactory;
    }

    /**
     * @Route("/start/{id}", name="start_homepage")
     */
    public function indexAction(Request $request, $id)
    {
        $workout = $this->getWorkoutRepository()->find($id);

        $trainings = $this->getWorkoutExercises($workout);

        return $this->render('@StartBundle/Start/index.html.twig', [
            'trainings' => $trainings
        ]);
    }


    /**
     * @Route("/start/{id}/confirm", name="start_training_confirm")
     *
     * @return RedirectResponse
     */
    public function trainingConfirmAction(Request $request, $id)
    {
        echo $id;

        //return $this->redirectToRoute('dashboard_homepage');
    }
}
