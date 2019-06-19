<?php

namespace Sport\Domain\Workout;

use Sport\Bundle\AppBundle\Entity\Workout;
use Sport\Bundle\AppBundle\Entity\WorkoutExercise;
use Sport\Domain\Exercise\ExerciseFactory;

class WorkoutFactory
{
    /**
     * @var ExerciseFactory
     */
    private $exerciseFactory;

    /**
     * @param ExerciseFactory $exerciseFactory
     */
    public function __construct(ExerciseFactory $exerciseFactory)
    {
        $this->exerciseFactory = $exerciseFactory;
    }

    /**
     * @param Workout $workout
     * @return WorkoutDTO
     */
    public function build(Workout $workout)
    {
        return $workout;
        $dto = new WorkoutDTO();
        $dto->id = $workout->getId();
        $dto->trainingName = $workout->getTraining()->getName();
        $dto->date = $workout->getDate();//->format('d/m/Y');
        $dto->exercises = $this->computeExercises($workout->getWorkoutExercises());

        return $dto;
    }

    private function computeExercises($workoutExerises)
    {
        $dtos = [];

        /** @var WorkoutExercise $workoutExerise */
        foreach ($workoutExerises as $workoutExerise)
        {
            $dtos[] = $this->exerciseFactory->build($workoutExerise->getExercise());
        }

        return $dtos;
    }
}