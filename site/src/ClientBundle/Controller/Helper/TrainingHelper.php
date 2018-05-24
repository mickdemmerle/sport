<?php

namespace Sport\Bundle\ClientBundle\Controller\Helper;

use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\NonUniqueResultException;
use Sport\Bundle\AppBundle\Repository\ExerciseRepository;
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
     * @param int $id
     *
     * @return TrainingDTO
     *
     * @throws TrainingNotFoundException
     * @throws NonUniqueResultException
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

    /**
     * @return array
     */
    private function getAllExercisesForOneMember()
    {
        $dtos = [];
        $member = $this->getUser();

        $exercises = $this->getExerciseRepository()->findAll();

        foreach ($exercises as $exercise) {
            $dtos[] = $this->exerciseFactory->build($exercise);
        }

        return $dtos;
    }

    /**
     * @return ObjectRepository|TrainingRepository
     */
    private function getTrainingRepository()
    {
        return $this->getDoctrine()->getRepository('Sport\Bundle\AppBundle\Entity\Training');
    }

    /**
     * @return ObjectRepository|ExerciseRepository
     */
    private function getExerciseRepository()
    {
        return $this->getDoctrine()->getRepository('Sport\Bundle\AppBundle\Entity\Exercise');
    }
}
