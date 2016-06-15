<?php

namespace Buero\PactBundle\DoctrineExtensions\Behaviours;

use Doctrine\ORM\Mapping as ORM;
use Buero\AccessBundle\DoctrineExtensions\Annotation\Timestampable;
use Buero\AccessBundle\DoctrineExtensions\Annotation\UpdateWithCurrentUser;
use Buero\AccessBundle\Entity\User;

trait CreateAndUpdateStampedTrait
{
    use CreateStampedTrait;

    /**
     * @var \DateTime Datum der letzten Bearbeitung (Durch den Benutzer selbst oder Administratoren)
     *
     * @Timestampable(on={"preUpdate", "prePersist"})
     */
    protected $updatedAt;

    /**
     * @var User Nutzer, welcher den Datensatz zuletzt aktualisiert hat
     *
     * @UpdateWithCurrentUser(on={"preUpdate", "prePersist"})
     */
    protected $updatedBy;

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return User|null
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }
}