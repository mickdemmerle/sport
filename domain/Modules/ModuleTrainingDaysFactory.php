<?php

namespace Sport\Domain\Modules;

use Sport\Bundle\AppBundle\Entity\Training;

class ModuleTrainingDaysFactory
{
    /**
     * @param array $days
     * @return array
     */
    public function build($days)
    {
        $trainingDays = [];
        $allDays = Training::getAllDays();

        foreach ($allDays as $allDaysId => $allDaysName) {

            $dto = new ModuleTrainingDaysDTO();
            $dto->id = $allDaysId;
            $dto->name = substr($allDaysName, 0, 3);
            $dto->isSelected = in_array($allDaysId, $days);

            $trainingDays[] = $dto;
        }

        return $trainingDays;
    }
}