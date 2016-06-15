<?php

namespace Buero\PactBundle\Entity;

use Buero\PactBundle\DoctrineExtensions\Behaviours as Behaviour;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Participant
 */
class Participant
{
    use Behaviour\CreateAndUpdateStampedTrait;

    public function __construct()
    {
        $this->badges = new ArrayCollection();
    }
    
    /**
     * @var int
     */
    private $id;

    /**
     * @var \stdClass
     */
    private $user;

    /**
     * @var Badge
     */
    private $badges;

    /**
     * @var int
     */
    private $experience;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set user
     *
     * @param \stdClass $user
     * @return Participant
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \stdClass 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set badges
     *
     * @param ArrayCollection $badges
     * @return Participant
     */
    public function setBadges($badges)
    {
        $this->badges = $badges;

        return $this;
    }

    /**
     * Get badges
     *
     * @return ArrayCollection 
     */
    public function getBadges()
    {
        return $this->badges;
    }

    /**
     * Set experience
     *
     * @param integer $experience
     * @return Participant
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience
     *
     * @return integer 
     */
    public function getExperience()
    {
        return $this->experience;
    }
}
