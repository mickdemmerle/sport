<?php

namespace Sport\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="workout_exercise")
 * @ORM\Entity(repositoryClass="Sport\Bundle\AppBundle\Repository\WorkoutExerciseRepository")
 */
class WorkoutExercise
{
    const DEFAULT_SERIE = 3;
    const DEFAULT_PERCENTAGE = 0.5;

    const STATUS_TODO = 0;
    const STATUS_DONE = 1;

    private static $percentages = [0.5, 0.6, 0.5, 0.6, 0.5, 0.6, 0.5];
    private static $series = [3, 4, 4, 3, 4, 3, 3];

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_on", type="datetime", nullable=false)
     */
    private $createdOn;

    /**
     * @var integer
     *
     * @ORM\Column(name="serie", type="integer", nullable=false)
     */
    private $serie;

    /**
     * @var integer
     *
     * @ORM\Column(name="repetition", type="integer", nullable=false)
     */
    private $repetition;

    /**
     * @var integer
     *
     * @ORM\Column(name="timeout", type="integer", nullable=false)
     */
    private $timeout;

    /**
     * @var Member
     *
     * @ORM\ManyToOne(targetEntity="Sport\Bundle\AppBundle\Entity\Member")
     * @ORM\JoinColumn(nullable=false)
     */
    private $member;

    /**
     * @var Workout
     *
     * @ORM\ManyToOne(targetEntity="Sport\Bundle\AppBundle\Entity\Workout", inversedBy="workoutExercises", cascade={"persist", "merge"}))
     * @ORM\JoinColumn(name="workout_id", referencedColumnName="id", nullable=false)
     */
    private $workout;

    /**
     * @var Exercise
     *
     * @ORM\ManyToOne(targetEntity="Sport\Bundle\AppBundle\Entity\Exercise")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exercise;

    /**
     * @param Member $member
     * @param Workout $workout
     * @param Exercise $exercise
     * @param int $serie
     * @param int $repetition
     * @param int $timeout
     */
    public function __construct(Member $member, Workout $workout, Exercise $exercise, $serie, $repetition, $timeout)
    {
        $this->createdOn = new \DateTime();
        $this->status = self::STATUS_TODO;
        $this->member = $member;
        $this->workout = $workout;
        $this->exercise = $exercise;
        $this->serie = $serie;
        $this->repetition = $repetition;
        $this->timeout = $timeout;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    /**
     * @return Member
     */
    public function getMember()
    {
        return $this->member;
    }

    /**
     * @param Member $member
     */
    public function setMember($member)
    {
        $this->member = $member;
    }

    /**
     * @return int
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param int $serie
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
    }

    /**
     * @return int
     */
    public function getRepetition()
    {
        return $this->repetition;
    }

    /**
     * @param int $repetition
     */
    public function setRepetition($repetition)
    {
        $this->repetition = $repetition;
    }

    /**
     * @return int
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * @return Workout
     */
    public function getWorkout()
    {
        return $this->workout;
    }

    /**
     * @param Workout $workout
     */
    public function setWorkout($workout)
    {
        $this->workout = $workout;
    }

    /**
     * @return Exercise
     */
    public function getExercise()
    {
        return $this->exercise;
    }

    /**
     * @param Exercise $exercise
     */
    public function setExercise($exercise)
    {
        $this->exercise = $exercise;
    }

    /**
     * @return array
     */
    public static function getPercentages()
    {
        return self::$percentages;
    }

    /**
     * @return array
     */
    public static function getSeries()
    {
        return self::$series;
    }
}

