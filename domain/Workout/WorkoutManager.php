<?php

namespace Sport\Domain\Workout;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Sport\Bundle\AppBundle\Entity\Exercise;
use Sport\Bundle\AppBundle\Entity\Member;
use Sport\Bundle\AppBundle\Entity\Training;
use Sport\Bundle\AppBundle\Entity\TrainingExercise;
use Sport\Bundle\AppBundle\Entity\Workout;
use Sport\Bundle\AppBundle\Entity\WorkoutExercise;
use Sport\Bundle\AppBundle\Repository\WorkoutExerciseRepository;
use Sport\Domain\WorkoutExercise\WorkoutExerciseManager;

class WorkoutManager
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var WorkoutExerciseManager
     */
    private $workoutExerciseManager;

    /**
     * @param EntityManagerInterface $entityManager
     * @param WorkoutExerciseManager $workoutExerciseManager
     */
    public function __construct(EntityManagerInterface $entityManager, WorkoutExerciseManager $workoutExerciseManager)
    {
        $this->entityManager = $entityManager;
        $this->workoutExerciseManager = $workoutExerciseManager;
    }

    /**
     * @param Training $training
     * @param Member $member
     * @param $sessionWorkoutCount
     * @param \DateTime $dateDays
     *
     * @throws \Exception
     */
    public function createSessionWorkout(Training $training, Member $member, $sessionWorkoutCount, \DateTime $dateDays)
    {
        $days = $training->getDays();

        $positionDays = $this->computeFirstPositionDays($dateDays,$days);
        $currentDay = $dateDays->format('w') - 1;

        $percentages = WorkoutExercise::getPercentages();
        $series = WorkoutExercise::getSeries();

        for ($i = 0; $i < $sessionWorkoutCount; $i++) {

            $daysCountToAdd = $this->calculateNumberOfDaysToAdd($currentDay, $days[$positionDays]);
            $dateDays->add(new \DateInterval('P' . $daysCountToAdd . 'D'));
            $currentDay = $days[$positionDays];

            $positionDays++;

            if ($positionDays >= count($days)) {
                $positionDays = 0;
            }

            $workout = $this->create($training, $member, clone $dateDays);
            $serie = (isset($series[$i])) ? $series[$i] : WorkoutExercise::DEFAULT_SERIE;
            $percentage = (isset($percentages[$i])) ? $percentages[$i] : WorkoutExercise::DEFAULT_PERCENTAGE;
            $timeout = ($i%2 == 0) ? 10 : 20;

            $this->createWorkoutExercises($member, $workout, $training->getTrainingExercises(), $serie, $percentage, $timeout);
        }
    }

    /**
     * @param Training $training
     * @param Member $member
     */
    public function removeAllSessionWorkoutsForOneMember(Training $training, Member $member)
    {
        /** @var Workout $workout */
        foreach ($training->getWorkouts() as $workout) {

            $workoutExercises = $this->getWorkoutExerciseRepository()->findBy(
                array(
                    'workout' => $workout,
                    'member' => $member
                )
            );

            /** @var WorkoutExercise $workoutExercise */
            foreach ($workoutExercises as $workoutExercise) {
                $this->entityManager->remove($workoutExercise);
            }

            $this->entityManager->remove($workout);
        }

        $this->entityManager->flush();
    }

    /**
     * @param Member $member
     * @param Workout $workout
     * @param $trainingExercises
     * @param int $serie
     * @param float $percentage
     * @param int $timeout
     */
    private function createWorkoutExercises(Member $member, Workout $workout, $trainingExercises, $serie, $percentage, $timeout)
    {
        /** @var TrainingExercise $trainingExercise */
        foreach($trainingExercises as $trainingExercise) {
            $repetitionMax = $trainingExercise->getRepetitionMax();
            $repetitionMaxFinal = round($repetitionMax * $percentage);

            $this->workoutExerciseManager->create($member, $workout, $trainingExercise->getExercise(), $serie, $repetitionMaxFinal, $timeout);
        }
    }

    /**
     * @param \DateTime $dateDays
     * @param array $days
     * @return int
     */
    private function computeFirstPositionDays(\DateTime $dateDays, $days)
    {
        $positionDays = 0;
        $currentDay = $dateDays->format('w') - 1;

        for ($i = 0; $i < count($days); $i++) {
            if ($days[$i] > $currentDay) {
                $positionDays = $i;
                break;
            }
        }

        return $positionDays;
    }

    /**
     * @param int $currentDay
     * @param int $daysPosition
     *
     * @return int
     */
    private function calculateNumberOfDaysToAdd($currentDay, $daysPosition)
    {
        if ($currentDay <= $daysPosition) {
            return $daysPosition - $currentDay;
        }

        return (6 - $currentDay) + ($daysPosition + 1);
    }

    /**
     * @param Training $training
     * @param Member $member
     * @param \DateTime $date
     *
     * @return Workout
     */
    public function create(Training $training, Member $member, $date)
    {
        $workout = new Workout($training, $member, $date);

        $this->entityManager->persist($workout);
        $this->entityManager->flush();

        return $workout;
    }

    /**
     * @return EntityRepository|WorkoutExerciseRepository
     */
    private function getWorkoutExerciseRepository()
    {
        return $this->entityManager->getRepository('Sport\Bundle\AppBundle\Entity\WorkoutExercise');
    }
}