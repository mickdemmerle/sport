<?php

namespace Sport\Domain\Training;

use Sport\Bundle\AppBundle\Entity\Training;

class TrainingFactory
{
    /**
     * @param Training $training
     * @return TrainingDTO
     */
    public function build(Training $training)
    {
        $dto = new TrainingDTO();
        $dto->name = $training->getName();
        $dto->days = $training->getDays();

        return $dto;
    }
}