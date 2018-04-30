<?php

namespace Sport\Bundle\ClientBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sport\Bundle\ClientBundle\Controller\Helper\ConfigurationHelper;
use Sport\Domain\Training\TrainingFactory;
use Sport\Domain\Training\TrainingManager;
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
     * @param TrainingManager $trainingManager
     * @param TrainingFactory $trainingFactory
     */
    public function __construct(TrainingManager $trainingManager, TrainingFactory $trainingFactory)
    {
        $this->trainingManager = $trainingManager;
        $this->trainingFactory = $trainingFactory;
    }

    /**
     * @Route("/configuration", name="dashboard_configuration")
     */
    public function indexAction(Request $request)
    {
        $trainings = $this->getAllTrainings();

        return $this->render('@ClientBundle/Configuration/index.html.twig', [
            'trainings' => $trainings
        ]);
    }

    /**
     * @Route("/configuration/add", name="dashboard_configuration_add_training")
     */
    public function addTraining(Request $request)
    {
        return $this->render('@ClientBundle/Configuration/add-training.html.twig', []);
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
