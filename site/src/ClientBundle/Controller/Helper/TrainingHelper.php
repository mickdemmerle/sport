<?php

namespace Sport\Bundle\ClientBundle\Controller\Helper;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\NonUniqueResultException;
use Sport\Bundle\AppBundle\Repository\TrainingRepository;
use Sport\Domain\Training\Exception\TrainingNotFoundException;
use Sport\Domain\Training\TrainingDTO;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;

trait TrainingHelper
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
     * @param int $id
     *
     * @return TrainingDTO
     *
     * @throws TrainingNotFoundException
     */
    private function getOneTraining($id)
    {
        $member = $this->getUser();

        $training = $this->getTrainingRepository()->findTraining($id, $member);

        if ($training === null) {
            throw new TrainingNotFoundException($id, $member);
        }

        return $this->trainingFactory->build($training);
    }
}
