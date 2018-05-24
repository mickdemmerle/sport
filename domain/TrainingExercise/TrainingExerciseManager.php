<?php

namespace Sport\Domain\TrainingExercise;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Sport\Bundle\AppBundle\Entity\Exercise;
use Sport\Bundle\AppBundle\Entity\Member;
use Sport\Bundle\AppBundle\Entity\Training;
use Sport\Bundle\AppBundle\Entity\TrainingExercise;
use Sport\Bundle\AppBundle\Repository\TrainingExerciseRepository;

class TrainingExerciseManager
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
     * @param Training $training
     * @param Member $member
     */
    public function removeAllForOneMember(Training $training, Member $member)
    {
        $trainingExercises = $this->getTrainingExerciseRepository()->findBy(array('training' => $training, 'member' => $member));

        foreach ($trainingExercises as $trainingExercise) {
            $this->entityManager->remove($trainingExercise);
        }

        $this->entityManager->flush();
    }

    /**
     * @param Training $training
     * @param Exercise $exercise
     * @param Member $member
     * @param int $repetitionMax
     */
    public function create(Training $training, Exercise $exercise, Member $member, $repetitionMax)
    {
        $trainingExercise = new TrainingExercise($training, $exercise, $member, $repetitionMax);

        $this->entityManager->persist($trainingExercise);
        $this->entityManager->flush();
    }

    /**
     * @return EntityRepository|TrainingExerciseRepository
     */
    private function getTrainingExerciseRepository()
    {
        return $this->entityManager->getRepository('Sport\Bundle\AppBundle\Entity\TrainingExercise');
    }
}