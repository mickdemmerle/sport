<?php

namespace Sport\Bundle\ClientBundle\Controller;

use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sport\Bundle\AppBundle\Entity\Training;
use Sport\Bundle\ClientBundle\Controller\Helper\TrainingHelper;
use Sport\Domain\Exercise\ExerciseFactory;
use Sport\Domain\Training\Exception\TrainingNotFoundException;
use Sport\Domain\Training\TrainingFactory;
use Sport\Domain\Training\TrainingManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TrainingController extends Controller
{
    use TrainingHelper;

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
     * @param TrainingManager $trainingManager
     * @param TrainingFactory $trainingFactory
     * @param ExerciseFactory $exerciseFactory
     */
    public function __construct(TrainingManager $trainingManager, TrainingFactory $trainingFactory, ExerciseFactory $exerciseFactory)
    {
        $this->trainingManager = $trainingManager;
        $this->trainingFactory = $trainingFactory;
        $this->exerciseFactory = $exerciseFactory;
    }

    /**
     * @Route("/configuration", name="dashboard_configuration")
     */
    public function indexAction(Request $request)
    {
        $trainings = $this->getAllTrainings();
        $exercises = $this->getAllExercisesForOneMember();

        return $this->render('@ClientBundle/Configuration/index.html.twig', [
            'trainings' => $trainings,
            'exercises' => $exercises
        ]);
    }

    /**
     * @Route("/configuration/add", name="dashboard_configuration_add_training")
     */
    public function addTraining(Request $request)
    {
        $exercises = $this->getAllExercisesForOneMember();

        return $this->render('@ClientBundle/Configuration/add-training.html.twig', [
            'allDays' => Training::getAllDays(),
            'exercises' => $exercises,
        ]);
    }

    /**
     * @Route("/configuration/edit/{id}", name="dashboard_configuration_edit_training")
     *
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws NonUniqueResultException
     * @throws TrainingNotFoundException
     */
    public function editTraining($id)
    {
        $training = $this->getOneTraining($id);
        $exercises = $this->getAllExercisesForOneMember();

        return $this->render('@ClientBundle/Configuration/edit-training.html.twig', [
            'training' => $training,
            'exercises' => $exercises,
            'allDays' => Training::getAllDays()
        ]);
    }


    /**
     * @Route("/configuration/edit/{id}/confirm", name="dashboard_configuration_edit_training_confirm")
     */
    public function editTrainingConfirm($id, Request $request)
    {
        $dto = $this->getDTO($request->request->all());
        $this->trainingManager->update($id, $dto, $this->getUser());

        return $this->redirectToRoute('dashboard_configuration');
    }

    /**
     * @Route("/configuration/add/confirm", name="dashboard_configuration_add_training_confirm")
     */
    public function addTrainingConfirm(Request $request)
    {
        $dto = $this->getDTO($request->request->all());
        $this->trainingManager->create($dto, $this->getUser());

        return $this->redirectToRoute('dashboard_configuration');
    }
}
