<?php

namespace Sport\Bundle\ClientBundle\Controller\Helper;

use Doctrine\Common\Persistence\ObjectRepository;
use Sport\Bundle\AppBundle\Entity\Workout;
use Sport\Bundle\AppBundle\Repository\WorkoutRepository;
use Sport\Domain\Training\Exception\WorkoutNotFoundException;
use Sport\Domain\Workout\SmallWorkoutDTO;
use Sport\Domain\Workout\SmallWorkoutFactory;

trait DashboardHelper
{
    /**
     * @return SmallWorkoutDTO[]
     *
     * @throws WorkoutNotFoundException
     */
    private function getNextWorkouts()
    {
        $member = $this->getUser();

        $workouts = $this->getWorkoutRepository()->findNextWorkouts($member);

        if (empty($workouts) === true) {
            throw new WorkoutNotFoundException($member);
        }

        $dtos = [];

        /** @var Workout $workout */
        foreach ($workouts as $workout)
        {
            $dtos[] = $this->smallWorkoutFactory->build($workout);
        }

        return $dtos;
    }

    /**
     * @param SmallWorkoutDTO[] $nextWorkouts
     *
     * @return int
     */
    private function computePositionWorkoutNow($nextWorkouts)
    {
        $countWorkoutsPast = 0;

        foreach ($nextWorkouts as $nextWorkout){
            if ($nextWorkout->status == SmallWorkoutFactory::WORKOUT_CLASS_PAST){
                $countWorkoutsPast++;
            }
        }

        return $countWorkoutsPast;
    }

    /**
     * @return ObjectRepository|WorkoutRepository
     */
    private function getWorkoutRepository()
    {
        return $this->getDoctrine()->getRepository('Sport\Bundle\AppBundle\Entity\Workout');
    }
}
