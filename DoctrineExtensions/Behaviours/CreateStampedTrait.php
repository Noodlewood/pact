<?php

namespace Buero\PactBundle\DoctrineExtensions\Behaviours;

use Doctrine\ORM\Mapping as ORM;
use Buero\AccessBundle\DoctrineExtensions\Annotation\Timestampable;
use Buero\AccessBundle\DoctrineExtensions\Annotation\UpdateWithCurrentUser;
use Buero\AccessBundle\Entity\User;

trait CreateStampedTrait
{
    /**
     * @var \DateTime Datum des Erstellens (Durch den Benutzer selbst oder Administratoren)
     *
     * @Timestampable(on={"prePersist"})
     */
    protected $createdAt;

    /**
     * @var User Nutzer, welcher den Datensatz erstellt hat
     *
     * @UpdateWithCurrentUser(on={"prePersist"})
     */
    protected $createdBy;

    /**
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return User|null
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }
}