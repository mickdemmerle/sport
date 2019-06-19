<?php

namespace Sport\Domain\Training;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Sport\Bundle\AppBundle\Entity\Member;
use Sport\Bundle\AppBundle\Entity\Training;
use Sport\Bundle\AppBundle\Repository\TrainingRepository;
use Sport\Domain\Exercise\ExerciseManager;
use Sport\Domain\Workout\WorkoutManager;

class TrainingManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ExerciseManager
     */
    private $exerciseManager;

    /**
     * @var WorkoutManager
     */
    private $workoutManager;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ExerciseManager $exerciseManager
     * @param WorkoutManager $workoutManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ExerciseManager $exerciseManager,
        WorkoutManager $workoutManager)
    {
        $this->entityManager = $entityManager;
        $this->exerciseManager = $exerciseManager;
        $this->workoutManager = $workoutManager;
    }

    /**
     * @param TrainingDTO $dto
     * @param Member $member
     *
     * @throws \Exception
     */
    public function create(TrainingDTO $dto, Member $member)
    {
        $this->createTraining($dto, $member);
    }

    /**
     * @param $id
     * @param TrainingDTO $dto
     * @param Member $member
     *
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Exception
     */
    public function update($id, TrainingDTO $dto, Member $member)
    {
        /** @var Training $training */
        $training = $this->getTrainingRepository()->findTraining($id, $member);
        $training->setName($dto->name)
            ->setDays($dto->days);

        $this->entityManager->flush();
    }

    /**
     * @param TrainingDTO $dto
     * @param Member $member
     *
     * @return Training
     */
    private function createTraining(TrainingDTO $dto, Member $member)
    {
        $training = new Training($dto->name, $member);
        $training->setDays($dto->days);

        $this->entityManager->persist($training);
        $this->entityManager->flush();

        return $training;
    }

    /**
     * @return EntityRepository|TrainingRepository
     */
    private function getTrainingRepository()
    {
        return $this->entityManager->getRepository('Sport\Bundle\AppBundle\Entity\Training');
    }
}