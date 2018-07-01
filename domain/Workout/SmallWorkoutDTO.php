<?php

namespace Sport\Domain\Workout;

use Sport\Domain\Exercise\ExerciseDTO;

class SmallWorkoutDTO
{
    /** @var int */
    public $id;

    /** @var string */
    public $trainingName;

    /** @var string */
    public $dateDay;

    /** @var string */
    public $dateMonth;

    /** @var ExerciseDTO[] */
    public $exercises;

    /** @var string */
    public $status;

    /** @var int */
    public $totalWorkoutExercises;

    public $totalWorkoutExercisesDone;
}