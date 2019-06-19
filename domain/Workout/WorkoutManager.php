<?php

namespace Sport\Domain\Workout;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Sport\Bundle\AppBundle\Entity\Member;
use Sport\Bundle\AppBundle\Entity\Training;
use Sport\Bundle\AppBundle\Entity\Workout;
use Sport\Bundle\AppBundle\Entity\WorkoutExercise;
use Sport\Bundle\AppBundle\Repository\WorkoutExerciseRepository;
use Sport\Domain\WorkoutExercise\WorkoutExerciseManager;

class WorkoutManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var WorkoutExerciseManager
     */
    private $workoutExerciseManager;

    /**
     * @param EntityManagerInterface $entityManager
     * @param WorkoutExerciseManager $workoutExerciseManager
     */
    public function __construct(EntityManagerInterface $entityManager, WorkoutExerciseManager $workoutExerciseManager)
    {
        $this->entityManager = $entityManager;
        $this->workoutExerciseManager = $workoutExerciseManager;
    }

    /**
     * @param Training $training
     * @param Member $member
     */
    public function removeAllSessionWorkoutsForOneMember(Training $training, Member $member)
    {
        /** @var Workout $workout */
        foreach ($training->getWorkouts() as $workout) {

            $workoutExercises = $this->getWorkoutExerciseRepository()->findBy(
                array(
                    'workout' => $workout,
                    'member' => $member
                )
            );

            /** @var WorkoutExercise $workoutExercise */
            foreach ($workoutExercises as $workoutExercise) {
                $this->entityManager->remove($workoutExercise);
            }

            $this->entityManager->remove($workout);
        }

        $this->entityManager->flush();
    }

    /**
     * @param Training $training
     * @param Member $member
     * @param \DateTime $date
     *
     * @return Workout
     */
    public function create(Training $training, Member $member, $date)
    {
        $workout = new Workout($training, $member, $date);

        $this->entityManager->persist($workout);
        $this->entityManager->flush();

        return $workout;
    }

    /**
     * @return EntityRepository|WorkoutExerciseRepository
     */
    private function getWorkoutExerciseRepository()
    {
        return $this->entityManager->getRepository('Sport\Bundle\AppBundle\Entity\WorkoutExercise');
    }
}