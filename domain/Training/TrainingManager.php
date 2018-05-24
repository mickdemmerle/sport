<?php

namespace Sport\Domain\Training;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Sport\Bundle\AppBundle\Entity\Member;
use Sport\Bundle\AppBundle\Entity\Training;

class TrainingManager
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
     * @param TrainingDTO $dto
     * @param Member $member
     */
    public function create(TrainingDTO $dto, Member $member)
    {
        $training = new Training($dto->name, $member);
        $training->setDays($dto->days);

        $this->entityManager->persist($training);
        $this->entityManager->flush();
    }
}