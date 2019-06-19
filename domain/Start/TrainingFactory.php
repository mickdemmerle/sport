<?php

namespace Sport\Domain\Start;

use Sport\Bundle\AppBundle\Entity\Workout;
use Sport\Bundle\AppBundle\Entity\WorkoutExercise;

class TrainingFactory
{
    /**
     * @param Workout $workout
     * @param WorkoutExercise[] $workoutExercises
     * @return TrainingDTO[]
     */
    public function build(Workout $workout, $workoutExercises)
    {
        $dtoByExercises = array();
        $maxSeries = 0;

        foreach ($workoutExercises as $workoutExercise) {

            if ($workoutExercise->getSerie() > $maxSeries) {
                $maxSeries = $workoutExercise->getSerie();
            }

            for ($i = 0; $i < $workoutExercise->getSerie(); $i++) {
                $dto = new TrainingDTO();
                $dto->id = $workoutExercise->getId();
                $dto->timeout = $workoutExercise->getTimeout();
                $dto->repetitions = $workoutExercise->getRepetition();
                $dto->name = $workoutExercise->getExercise()->getName();

                $dtoByExercises[$workoutExercise->getExercise()->getId()][] = $dto;
            }
        }

        $sortTrainings = $this->sortTrainings($dtoByExercises, $maxSeries);

        return $this->selectTrainingsWithProgression($sortTrainings, $workout->getProgression());
    }

    /**
     * @param TrainingDTO[] $trainings
     * @param int $maxSeries
     * @return array
     */
    private function sortTrainings($trainings, $maxSeries)
    {
        $sortTrainings = array();

        for ($i = 0; $i < $maxSeries; $i++) {
            foreach ($trainings as $training) {
                if (isset($training[$i]) === true) {
                    $sortTrainings[] = $training[$i];
                }
            }
        }

        return $sortTrainings;
    }

    /**
     * @param TrainingDTO[] $trainings
     * @param int $progression
     * @return array
     */
    private function selectTrainingsWithProgression($trainings, $progression)
    {
        if ($progression === 0) {
            return $trainings;
        }

        return array_slice($trainings, $progression, count($trainings));
    }
}