<?php

namespace Sport\Domain\WorkoutExercise;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sport\Bundle\AppBundle\Entity\Exercise;
use Sport\Bundle\AppBundle\Entity\Member;
use Sport\Bundle\AppBundle\Entity\Workout;
use Sport\Bundle\AppBundle\Entity\WorkoutExercise;

class WorkoutExerciseManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function create(Member $member, Workout $workout, Exercise $exercise, $serie, $repetition, $timeout)
    {
        $workoutExercise = new WorkoutExercise($member, $workout, $exercise, $serie, $repetition, $timeout);

        $this->entityManager->persist($workoutExercise);
        $this->entityManager->flush();
    }
}