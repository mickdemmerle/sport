<?php

namespace Sport\Bundle\ClientBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sport\Bundle\ClientBundle\Controller\Helper\ConfigurationHelper;
use Sport\Domain\Exercise\ExerciseFactory;
use Sport\Domain\Training\TrainingFactory;
use Sport\Domain\Training\TrainingManager;
use Sport\Domain\Workout\WorkoutFactory;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ConfigurationController extends Controller
{
    use ConfigurationHelper;

    /**
     * @var TrainingManager
     */
    private $trainingManager;

    /**
     * @var TrainingFactory
     */
    private $trainingFactory;

    /**
     * @var ExerciseFactory
     */
    private $exerciseFactory;

    /**
     * @var WorkoutFactory
     */
    private $workoutFactory;

    /**
     * @param TrainingManager $trainingManager
     * @param TrainingFactory $trainingFactory
     * @param ExerciseFactory $exerciseFactory
     * @param WorkoutFactory $workoutFactory
     */
    public function __construct(
        TrainingManager $trainingManager,
        TrainingFactory $trainingFactory,
        ExerciseFactory $exerciseFactory,
        WorkoutFactory $workoutFactory
    )
    {
        $this->trainingManager = $trainingManager;
        $this->trainingFactory = $trainingFactory;
        $this->exerciseFactory = $exerciseFactory;
        $this->workoutFactory = $workoutFactory;
    }

    /**
     * @Route("/configuration", name="dashboard_configuration")
     */
    public function indexAction(Request $request)
    {
        $member = $this->getUser();

        $trainings = $this->getAllTrainingsForOneMember($member);
        $exercises = $this->getAllExercisesForOneMember($member);
        $workouts = $this->getAllWorkoutsForOneMember($member);

        return $this->render('@ClientBundle/Configuration/index.html.twig', [
            'trainings' => $trainings,
            'exercises' => $exercises,
            'workouts' => $workouts
        ]);
    }
}
