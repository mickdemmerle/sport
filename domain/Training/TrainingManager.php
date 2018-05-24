<?php

namespace Sport\Domain\Training;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Sport\Bundle\AppBundle\Entity\Exercise;
use Sport\Bundle\AppBundle\Entity\Member;
use Sport\Bundle\AppBundle\Entity\Training;
use Sport\Bundle\AppBundle\Repository\ExerciseRepository;
use Sport\Bundle\AppBundle\Repository\TrainingRepository;
use Sport\Domain\Exercise\ExerciseManager;
use Sport\Domain\TrainingExercise\TrainingExerciseManager;
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
     * @var TrainingExerciseManager
     */
    private $trainingExerciseManager;

    /**
     * @var WorkoutManager
     */
    private $workoutManager;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ExerciseManager $exerciseManager
     * @param TrainingExerciseManager $trainingExerciseManager
     * @param WorkoutManager $workoutManager
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ExerciseManager $exerciseManager,
        TrainingExerciseManager $trainingExerciseManager,
        WorkoutManager $workoutManager)
    {
        $this->entityManager = $entityManager;
        $this->exerciseManager = $exerciseManager;
        $this->trainingExerciseManager = $trainingExerciseManager;
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
        $training = $this->createTraining($dto, $member);
        $this->createAllExercises($dto, $training, $member);

        $dateStart = new \DateTime($dto->sessionWorkoutDateStart);
        $training = $this->getTrainingRepository()->findTraining($training->getId(), $member);
        $this->workoutManager->createSessionWorkout($training, $member, $dto->sessionWorkoutCount, $dateStart);
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

        $this->workoutManager->removeAllSessionWorkoutsForOneMember($training, $member);
        $this->trainingExerciseManager->removeAllForOneMember($training, $member);
        $this->createAllExercises($dto, $training, $member);

        $this->entityManager->clear('Sport\Bundle\AppBundle\Entity\Training');

        $training = $this->getTrainingRepository()->findTraining($id, $member);
        $dateStart = new \DateTime($dto->sessionWorkoutDateStart);
        $this->workoutManager->createSessionWorkout($training, $member, $dto->sessionWorkoutCount, $dateStart);
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
     * @param TrainingDTO $dto
     * @param Training $training
     * @param Member $member
     */
    private function createAllExercises(TrainingDTO $dto, Training $training, Member $member)
    {
        foreach ($dto->exercisesName as $exercisePostion => $exerciseId) {
            $repetitionMax = $dto->exercisesRM[$exercisePostion];

            if ($exerciseId != "" && $repetitionMax != "") {

                /** @var Exercise $exercise */
                $exercise = $this->getExerciseRepository()->find($exerciseId);

                $this->trainingExerciseManager->create($training, $exercise, $member, $repetitionMax);
            }
        }
    }

    /**
     * @return EntityRepository|TrainingRepository
     */
    private function getTrainingRepository()
    {
        return $this->entityManager->getRepository('Sport\Bundle\AppBundle\Entity\Training');
    }

    /**
     * @return EntityRepository|ExerciseRepository
     */
    private function getExerciseRepository()
    {
        return $this->entityManager->getRepository('Sport\Bundle\AppBundle\Entity\Exercise');
    }
}