<?php

namespace Sport\Domain\Exercise;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Sport\Bundle\AppBundle\Entity\Exercise;
use Sport\Bundle\AppBundle\Entity\Member;
use Sport\Bundle\AppBundle\Entity\Training;
use Sport\Bundle\AppBundle\Repository\ExerciseRepository;

class ExerciseManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param ExerciseDTO $dto
     * @param Member $member
     * @param Training $training
     *
     * @return Exercise
     */
    public function create(ExerciseDTO $dto, Member $member)
    {
        $exercise = new Exercise($dto->name, $member);

        $this->entityManager->persist($exercise);
        $this->entityManager->flush();

        return $exercise;
    }

    /**
     * @param int $id
     * @param ExerciseDTO $dto
     * @param Member $member
     * @throws NonUniqueResultException
     */
    public function update($id, ExerciseDTO $dto, Member $member)
    {
        /** @var Exercise $exercise */
        $exercise = $this->getExerciseRepository()->findExercise($id, $member);
        $exercise->setName($dto->name);

        $this->entityManager->flush();
    }

    /**
     * @return EntityRepository|ExerciseRepository
     */
    private function getExerciseRepository()
    {
        return $this->entityManager->getRepository('Sport\Bundle\AppBundle\Entity\Exercise');
    }
}