<?php

namespace Sport\Bundle\ClientBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sport\Bundle\ClientBundle\Controller\Helper\DashboardHelper;
use Sport\Domain\Workout\SmallWorkoutFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    use DashboardHelper;

    /**
     * @var SmallWorkoutFactory
     */
    private $smallWorkoutFactory;

    /**
     * @param SmallWorkoutFactory $smallWorkoutFactory
     */
    public function __construct(SmallWorkoutFactory $smallWorkoutFactory)
    {
        $this->smallWorkoutFactory = $smallWorkoutFactory;
    }

    /**
     * @Route("/", name="dashboard_homepage")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Sport\Domain\Training\Exception\WorkoutNotFoundException
     */
    public function indexAction(Request $request)
    {
        $nextWorkouts = $this->getNextWorkouts();
        $positionWorkoutNow = $this->computePositionWorkoutNow($nextWorkouts);

        return $this->render('@ClientBundle/Homepage/index.html.twig', [
            'nextWorkouts' => $nextWorkouts,
            'positionWorkoutNow' => $positionWorkoutNow
        ]);
    }
}
