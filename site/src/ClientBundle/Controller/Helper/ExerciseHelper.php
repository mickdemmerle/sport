<?php

namespace Sport\Bundle\ClientBundle\Controller\Helper;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\NonUniqueResultException;
use Sport\Bundle\AppBundle\Repository\ExerciseRepository;
use Sport\Bundle\AppBundle\Repository\TrainingRepository;
use Sport\Domain\Exercise\ExerciseDTO;
use Sport\Domain\Training\Exception\ExerciseNotFoundException;
use Sport\Domain\Training\Exception\TrainingNotFoundException;
use Sport\Domain\Training\TrainingDTO;
use Symfony\Component\Serializer\Normalizer\PropertyNormalizer;

trait ExerciseHelper
{
    /**
     * @param Object|array $data
     *
     * @return ExerciseDTO
     */
    private function getDTO($data)
    {
        /** @var PropertyNormalizer $getSetMethodNormalizer */
        $normalizer = $this->get('property_normalizer');
        $dto = $normalizer->denormalize($data,
            'Sport\Domain\Exercise\ExerciseDTO');
        return $dto;
    }


    private function getOneExercise($id)
    {
        $member = $this->getUser();

        $exercise = $this->getExerciseRepository()->findExercise($id, $member);

        if ($exercise === null) {
            throw new ExerciseNotFoundException($id, $member);
        }

        return $this->exerciseFactory->build($exercise);
    }

    /**
     * @return ObjectRepository|ExerciseRepository
     */
    private function getExerciseRepository()
    {
        return $this->getDoctrine()->getRepository('Sport\Bundle\AppBundle\Entity\Exercise');
    }
}
