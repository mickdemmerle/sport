<?php

namespace Sport\Domain\Workout;

use Sport\Domain\Exercise\ExerciseDTO;

class WorkoutDTO
{
    /** @var int */
    public $id;

    /** @var string */
    public $trainingName;

    /** @var string */
    public $date;

    /** @var ExerciseDTO[] */
    public $exercises;
}