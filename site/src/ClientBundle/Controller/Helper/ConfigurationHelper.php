<?php

namespace Sport\Bundle\ClientBundle\Controller\Helper;

use Doctrine\Common\Persistence\ObjectRepository;
use Sport\Bundle\AppBundle\Repository\TrainingRepository;
use Sport\Domain\Training\TrainingDTO;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;

trait ConfigurationHelper
{
    /**
     * @param Object|array $data
     *
     * @return TrainingDTO
     */
    private function getDTO($data)
    {
        /** @var PropertyNormalizer $getSetMethodNormalizer */
        $normalizer = $this->get('property_normalizer');
        $dto = $normalizer->denormalize($data,
            'Sport\Domain\Training\TrainingDTO');
        return $dto;
    }

    /**
     * @return array
     */
    private function getAllTrainings()
    {
        $trainings = $this->getTrainingRepository()->findTrainingsByMember($this->getUser());
        $trainingDTOs = [];

        foreach ($trainings as $training) {
            $trainingDTOs[] = $this->trainingFactory->build($training);
        }

        return $trainingDTOs;
    }

    /**
     * @return ObjectRepository|TrainingRepository
     */
    private function getTrainingRepository()
    {
        return $this->getDoctrine()->getRepository('Sport\Bundle\AppBundle\Entity\Training');
    }
}
