<?php

namespace Sport\Domain\Exercise;

use Sport\Bundle\AppBundle\Entity\Exercise;

class ExerciseFactory
{
    /**
     * @param Exercise $exercise
     * @param int $repetitionMax
     *
     * @return ExerciseDTO
     */
    public function build(Exercise $exercise, $repetitionMax = null)
    {
        $dto = new ExerciseDTO();
        $dto->id = $exercise->getId();
        $dto->name = $exercise->getName();
        $dto->repetitionMax = $repetitionMax;

        return $dto;
    }
}