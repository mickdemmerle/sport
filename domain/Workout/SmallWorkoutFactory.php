<?php

namespace Sport\Domain\Workout;

use Sport\Bundle\AppBundle\Entity\Workout;
use Sport\Bundle\AppBundle\Entity\WorkoutExercise;
use Sport\Domain\Exercise\ExerciseFactory;

class SmallWorkoutFactory
{
    const WORKOUT_CLASS_PAST = 'status-past';
    const WOKOUT_CLASS_FUTUR = 'status-futur';
    const WOKOUT_CLASS_NOW = 'status-now';

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
     * @return SmallWorkoutDTO
     */
    public function build(Workout $workout)
    {
        $dto = new SmallWorkoutDTO();
        $dto->id = $workout->getId();
        $dto->trainingName = $workout->getTraining()->getName();
        $dto->dateDay = $workout->getDate()->format('d');
        $dto->dateMonth = $workout->getDate()->format('F');
        $dto->exercises = $this->computeExercises($workout->getWorkoutExercises());
        $dto->status = $this->computeStatus($workout->getDate());
        $dto->totalWorkoutExercises = count($workout->getWorkoutExercises());
        $dto->totalWorkoutExercisesDone = $this->computeTotalWorkoutExercisesDone($workout->getWorkoutExercises());

        return $dto;
    }

    /**
     * @param array $workoutExerises
     *
     * @return array
     */
    private function computeExercises($workoutExerises)
    {
        $dtos = [];

        /** @var WorkoutExercise $workoutExerise */
        foreach ($workoutExerises as $workoutExerise) {
            $dtos[] = $this->exerciseFactory->build($workoutExerise->getExercise());
        }

        return $dtos;
    }

    /**
     * @param \DateTime $date
     *
     * @return string
     */
    private function computeStatus(\DateTime $date)
    {
        $now = new \DateTime();

        if ($now->format('d/m/Y') == $date->format('d/m/Y')) {
            return self::WOKOUT_CLASS_NOW;
        }

        if ($now > $date) {
            return self::WORKOUT_CLASS_PAST;
        }

        return self::WOKOUT_CLASS_FUTUR;
    }

    /**
     * @param WorkoutExercise[] $workoutExercises
     *
     * @return int
     */
    private function computeTotalWorkoutExercisesDone($workoutExercises)
    {
        $count = 0;
        /*
        foreach ($workoutExercises as $workoutExercise) {
            if ($workoutExercise->getStatus() === WorkoutExercise::STATUS_DONE) {
                $count++;
            }
        }
        */
        return $count;
    }
}