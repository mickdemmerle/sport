<?php

namespace Sport\Bundle\StartBundle\Controller\Helper;

use Doctrine\Common\Persistence\ObjectRepository;
use Sport\Bundle\AppBundle\Entity\Workout;
use Sport\Bundle\AppBundle\Repository\WorkoutExerciseRepository;
use Sport\Bundle\AppBundle\Repository\WorkoutRepository;

trait IndexHelper
{
    /**
     * @param Workout $workout
     * @return array
     */
    private function getWorkoutExercises(Workout $workout)
    {
        $member = $this->getUser();
        $workoutExercises = $this->getWorkoutExerciseRepository()->findWorkoutExercisesByMember($workout, $member);

        return $this->trainingFactory->build($workout, $workoutExercises);
    }

    /**
     * @return ObjectRepository|WorkoutExerciseRepository
     */
    private function getWorkoutExerciseRepository()
    {
        return $this->getDoctrine()->getRepository('Sport\Bundle\AppBundle\Entity\WorkoutExercise');
    }

    /**
     * @return ObjectRepository|WorkoutRepository
     */
    private function getWorkoutRepository()
    {
        return $this->getDoctrine()->getRepository('Sport\Bundle\AppBundle\Entity\Workout');
    }
}
