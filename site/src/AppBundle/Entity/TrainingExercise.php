<?php

namespace Sport\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="training_exercise")
 * @ORM\Entity(repositoryClass="Sport\Bundle\AppBundle\Repository\TrainingExerciseRepository")
 */
class TrainingExercise
{
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
     * @ORM\Column(name="repetition_max", type="integer")
     */
    private $repetitionMax;

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
     * @ORM\ManyToOne(targetEntity="Sport\Bundle\AppBundle\Entity\Training", inversedBy="trainingExercises", cascade={"persist", "merge"}))
     * @ORM\JoinColumn(name="training_id", referencedColumnName="id", nullable=false)
     */
    private $training;

    /**
     * @var Exercise
     *
     * @ORM\ManyToOne(targetEntity="Sport\Bundle\AppBundle\Entity\Exercise")
     * @ORM\JoinColumn(nullable=false)
     */
    private $exercise;

    /**
     * @param Training $training
     * @param Exercise $exercise
     * @param Member $member
     * @param int $repetitionMax
     */
    public function __construct(Training $training, Exercise $exercise, Member $member, $repetitionMax)
    {
        $this->createdOn = new \DateTime();
        $this->training = $training;
        $this->exercise = $exercise;
        $this->member = $member;
        $this->repetitionMax = $repetitionMax;
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getRepetitionMax()
    {
        return $this->repetitionMax;
    }

    /**
     * @param int $repetitionMax
     */
    public function setRepetitionMax($repetitionMax)
    {
        $this->repetitionMax = $repetitionMax;
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
}

