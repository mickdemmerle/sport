<?php

namespace Sport\Bundle\AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="training")
 * @ORM\Entity(repositoryClass="Sport\Bundle\AppBundle\Repository\TrainingRepository")
 */
class Training
{
    const DAY_MONDAY = 0;
    const DAY_TUESDAY = 1;
    const DAY_WEDNESDAY = 2;
    const DAY_THURSDAY = 3;
    const DAY_FRIDAY = 4;
    const DAY_SATURDAY = 5;
    const DAY_SUNDAY = 6;

    private static $allDays = [
        self::DAY_MONDAY => 'lundi',
        self::DAY_TUESDAY => 'mardi',
        self::DAY_WEDNESDAY => 'mercredi',
        self::DAY_THURSDAY => 'jeudi',
        self::DAY_FRIDAY => 'vendredi',
        self::DAY_SATURDAY => 'samedi',
        self::DAY_SUNDAY => 'dimanche',
    ];

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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var array
     *
     * @ORM\Column(name="days", type="array")
     */
    private $days;

    /**
     * @var Member $member
     *
     * @ORM\ManyToOne(targetEntity="Sport\Bundle\AppBundle\Entity\Member", inversedBy="trainings", cascade={"persist", "merge"})
     * @ORM\JoinColumn(name="member_id", referencedColumnName="id")
     */
    private $member;


    /**
     * @var array $workouts
     *
     * @ORM\OneToMany(targetEntity="Sport\Bundle\AppBundle\Entity\Workout", mappedBy="training", cascade={"persist", "remove", "merge"})
     */
    private $workouts;

    public function __construct($name, $member)
    {
        $this->createdOn = new \DateTime();
        $this->name = $name;
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return array
     */
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param array $days
     *
     * @return $this
     */
    public function setDays($days)
    {
        $this->days = $days;

        return $this;
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
     *
     * @return $this
     */
    public function setMember($member)
    {
        $this->member = $member;

        return $this;
    }

    /**
     * @return array
     */
    public static function getAllDays()
    {
        return self::$allDays;
    }

    /**
     * @return array
     */
    public function getWorkouts()
    {
        return $this->workouts;
    }

    /**
     * @param array $workouts
     */
    public function setWorkouts($workouts)
    {
        $this->workouts = $workouts;
    }
}

