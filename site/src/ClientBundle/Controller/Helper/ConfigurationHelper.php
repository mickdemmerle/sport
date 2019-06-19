<?php

namespace Sport\Bundle\ClientBundle\Controller\Helper;

use Doctrine\Common\Persistence\ObjectRepository;
use Sport\Bundle\AppBundle\Entity\Member;
use Sport\Bundle\AppBundle\Repository\ExerciseRepository;
use Sport\Bundle\AppBundle\Repository\TrainingRepository;
use Sport\Bundle\AppBundle\Repository\WorkoutRepository;

trait ConfigurationHelper
{
    /**
     * @param Member $member
     *
     * @return array
     */
    private function getAllTrainingsForOneMember(Member $member)
    {
        $trainings = $this->getTrainingRepository()->findTrainingsByMember($member);
        $trainingDTOs = [];

        foreach ($trainings as $training) {
            $trainingDTOs[] = $this->trainingFactory->build($training);
        }

        return $trainingDTOs;
    }

    /**
     * @param Member $member
     *
     * @return array
     */
    private function getAllExercisesForOneMember(Member $member)
    {
        $dtos = [];

        $exercises = $this->getExerciseRepository()->findExercisesByMember($member);

        foreach ($exercises as $exercise) {
            $dtos[] = $this->exerciseFactory->build($exercise);
        }

        return $dtos;
    }

    private function getAllWorkoutsForOneMember(Member $member)
    {
        $dtos = [];

        $workouts = $this->getWorkoutRepository()->findWorkoutsByMember($member);

        foreach ($workouts as $workout) {
            $dtos[] = $this->workoutFactory->build($workout);
        }

        return $dtos;
    }

    /**
     * @return ObjectRepository|TrainingRepository
     */
    private function getTrainingRepository()
    {
        return $this->getDoctrine()->getRepository('Sport\Bundle\AppBundle\Entity\Training');
    }

    /**
     * @return ObjectRepository|ExerciseRepository
     */
    private function getExerciseRepository()
    {
        return $this->getDoctrine()->getRepository('Sport\Bundle\AppBundle\Entity\Exercise');
    }

    /**
     * @return ObjectRepository|WorkoutRepository
     */
    private function getWorkoutRepository()
    {
        return $this->getDoctrine()->getRepository('Sport\Bundle\AppBundle\Entity\Workout');
    }
}
