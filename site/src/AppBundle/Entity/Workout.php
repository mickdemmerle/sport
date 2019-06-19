<?php

namespace Sport\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="workout")
 * @ORM\Entity(repositoryClass="Sport\Bundle\AppBundle\Repository\WorkoutRepository")
 */
class Workout
{
    const NUMBER_WORKOUT_DASHBOARD = 14;

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
     * @ORM\Column(name="status", type="smallint", options={"default" = 0}, nullable=false)
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="progression", type="smallint", options={"default" = 0}, nullable=false)
     */
    private $progression;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var Member
     *
     * @ORM\ManyToOne(targetEntity="Sport\Bundle\AppBundle\Entity\Member")
     * @ORM\JoinColumn(nullable=false)
     */
    private $member;

    /**
     * @var Training
     *
     * @ORM\ManyToOne(targetEntity="Sport\Bundle\AppBundle\Entity\Training", inversedBy="workouts", cascade={"persist", "merge"}))
     * @ORM\JoinColumn(name="training_id", referencedColumnName="id", nullable=false)
     */
    private $training;

    /**
     * @var array $workoutExercises
     *
     * @ORM\OneToMany(targetEntity="Sport\Bundle\AppBundle\Entity\WorkoutExercise", mappedBy="workout", cascade={"persist", "remove", "merge"})
     */
    private $workoutExercises;

    /**
     * @param Training $training
     * @param Member $member
     * @param \Datetime $date
     */
    public function __construct(Training $training, Member $member, $date)
    {
        $this->createdOn = new \DateTime();
        $this->date = $date;
        $this->training = $training;
        $this->member = $member;
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
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getProgression()
    {
        return $this->progression;
    }

    /**
     * @param int $progression
     */
    public function setProgression($progression)
    {
        $this->progression = $progression;
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
     * @return Training
     */
    public function getTraining()
    {
        return $this->training;
    }

    /**
     * @param Training $training
     */
    public function setTraining($training)
    {
        $this->training = $training;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate(\DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return array
     */
    public function getWorkoutExercises()
    {
        return $this->workoutExercises;
    }

    /**
     * @param array $workoutExercises
     */
    public function setWorkoutExercises($workoutExercises)
    {
        $this->workoutExercises = $workoutExercises;
    }
}

