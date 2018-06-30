<?php

namespace Sport\Bundle\ClientBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sport\Bundle\ClientBundle\Controller\Helper\ConfigurationHelper;
use Sport\Bundle\ClientBundle\Controller\Helper\ExerciseHelper;
use Sport\Domain\Exercise\ExerciseFactory;
use Sport\Domain\Exercise\ExerciseManager;
use Sport\Domain\Training\Exception\ExerciseNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ExerciseController extends Controller
{
    use ExerciseHelper;

    /**
     * @var ExerciseManager
     */
    private $exerciseManager;

    /**
     * @var ExerciseFactory
     */
    private $exerciseFactory;

    /**
     * @param ExerciseManager $exerciseManager
     * @param ExerciseFactory $exerciseFactory
     */
    public function __construct(ExerciseManager $exerciseManager, ExerciseFactory $exerciseFactory)
    {
        $this->exerciseManager = $exerciseManager;
        $this->exerciseFactory = $exerciseFactory;
    }

    /**
     * @Route("/configuration/exercise/add", name="dashboard_configuration_add_exercise")
     */
    public function addExercise(Request $request)
    {
        return $this->render('@ClientBundle/Configuration/add-exercise.html.twig', [
        ]);
    }

    /**
     * @Route("/configuration/exercise/add/confirm", name="dashboard_configuration_add_exercise_confirm")
     */
    public function addExerciseConfirm(Request $request)
    {
        $dto = $this->getDTO($request->request->all());
        $this->exerciseManager->create($dto, $this->getUser());

        return $this->redirectToRoute('dashboard_configuration');
    }

    /**
     * @Route("/configuration/exercise/edit/{id}", name="dashboard_configuration_edit_exercise")
     *
     * @param int $id
     * @return Response
     * @throws ExerciseNotFoundException
     */
    public function editExercise($id)
    {
        $exercise = $this->getOneExercise($id);

        return $this->render('@ClientBundle/Configuration/edit-exercise.html.twig', [
            'exercise' => $exercise
        ]);
    }

    /**
     * @Route("/configuration/exercise/edit/{id}/confirm", name="dashboard_configuration_edit_exercise_confirm")
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function editExerciseConfirm($id, Request $request)
    {
        $dto = $this->getDTO($request->request->all());
        $this->exerciseManager->update($id, $dto, $this->getUser());

        return $this->redirectToRoute('dashboard_configuration');
    }
}
