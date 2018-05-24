<?php

namespace Sport\Bundle\AppBundle\Entity;

use FOS\UserBundle\Model\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="member")
 * @ORM\Entity()
 * @ORM\AttributeOverrides({
 *     @ORM\AttributeOverride(name="salt", column=@ORM\Column(nullable=true))
 * })
 */
class Member extends User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="first_name", type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your first name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $firstName;

    /**
     * @ORM\Column(name="last_name", type="string", length=255)
     *
     * @Assert\NotBlank(message="Please enter your last name.", groups={"Registration", "Profile"})
     * @Assert\Length(
     *     min=3,
     *     max=255,
     *     minMessage="The name is too short.",
     *     maxMessage="The name is too long.",
     *     groups={"Registration", "Profile"}
     * )
     */
    protected $lastName;

    /**
     * @var array $exercises
     *
     * @ORM\OneToMany(targetEntity="Sport\Bundle\AppBundle\Entity\Exercise", mappedBy="member", cascade={"persist", "remove", "merge"})
     */
    private $exercises;

    /**
     * @var array $trainings
     *
     * @ORM\OneToMany(targetEntity="Sport\Bundle\AppBundle\Entity\Training", mappedBy="member", cascade={"persist", "remove", "merge"})
     */
    private $trainings;

    public function __construct()
    {
        parent::__construct();
        $this->salt = base_convert(sha1(uniqid(mt_rand(), true)), 16, 36);

    }

    /**
     * {@inheritdoc}
     */
    public function setEmail($email)
    {
        $this->email = $email;
        $this->setUsername($email);

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return array
     */
    public function getExercises()
    {
        return $this->exercises;
    }

    /**
     * @param array $exercises
     */
    public function setExercises($exercises)
    {
        $this->exercises = $exercises;
    }

    /**
     * @return array
     */
    public function getTrainings()
    {
        return $this->trainings;
    }

    /**
     * @param array $trainings
     */
    public function setTrainings($trainings)
    {
        $this->trainings = $trainings;
    }
}

