<?php

namespace Sport\Domain\Training;

use Sport\Bundle\AppBundle\Entity\Training;
use Sport\Bundle\AppBundle\Entity\TrainingExercise;
use Sport\Domain\Exercise\ExerciseFactory;
use Sport\Domain\Modules\ModuleTrainingDaysFactory;

class TrainingFactory
{
    /**
     * @var ExerciseFactory
     */
    private $exerciseFactory;

    /**
     * @var ModuleTrainingDaysFactory
     */
    private $moduleTrainingDaysFactory;

    /**
     * @param ExerciseFactory $exerciseFactory
     * @param ModuleTrainingDaysFactory $moduleTrainingDaysFactory
     */
    public function __construct(ExerciseFactory $exerciseFactory, ModuleTrainingDaysFactory $moduleTrainingDaysFactory)
    {
        $this->exerciseFactory = $exerciseFactory;
        $this->moduleTrainingDaysFactory = $moduleTrainingDaysFactory;
    }

    /**
     * @param Training $training
     * @return TrainingDTO
     */
    public function build(Training $training)
    {
        $dto = new TrainingDTO();
        $dto->id = $training->getId();
        $dto->name = $training->getName();
        $dto->days = $this->computeDays($training->getDays());
        $dto->exercises = $this->computeExercises($training->getTrainingExercises());
        $dto->moduleDays = $this->moduleTrainingDaysFactory->build($training->getDays());
        $dto->sessionWorkoutCount = count($training->getWorkouts());
        $dto->workouts = $this->computeWorkouts($training->getWorkouts());

        return $dto;
    }

    /**
     * @param array $dayIds
     * @return array
     */
    private function computeDays(array $dayIds)
    {
        $allDays = Training::getAllDays();
        $days = [];

        foreach ($dayIds as $dayId) {
            $days[$dayId] = $allDays[$dayId];
        }

        return $days;
    }

    /**
     * @param array $trainingExercises
     * @return array
     */
    private function computeExercises($trainingExercises)
    {
        $dtos = array();

        /** @var TrainingExercise $trainingExercise */
        foreach ($trainingExercises as $trainingExercise) {
            $dtos[] = $this->exerciseFactory->build(
                $trainingExercise->getExercise(),
                $trainingExercise->getRepetitionMax()
            );
        }

        return $dtos;
    }

    private function computeWorkouts($workouts)
    {
        return $workouts;
    }
}