<?php

namespace Sport\Domain\Training;

class TrainingDTO {

    /** @var int */
    public $id;

    /** @var string */
    public $name;

    /** @var array */
    public $days;

    /** @var array */
    public $exercisesName;

    /** @var array */
    public $exercisesRM;

    /** @var array */
    public $exercises;

    /** @var  */
    public $moduleDays;

    /** @var array */
    public $sessionWorkoutCount;

    /** @var string */
    public $sessionWorkoutDateStart;

    /** @var array */
    public $workouts;
}