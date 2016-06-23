<?php

namespace Buero\PactBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Task
 */
class Task
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $entityName;

    /**
     * @var array
     */
    private $fields;

    /**
     * @var string
     */
    private $routeUrl;

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
     * Set entityName
     *
     * @param string $entityName
     * @return Task
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;

        return $this;
    }

    /**
     * Get entityName
     *
     * @return string 
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * Set fields
     *
     * @param array $fields
     * @return Task
     */
    public function setFields($fields)
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * Get fields
     *
     * @return array 
     */
    public function getFields()
    {
        return $this->fields;
    }

    /**
     * @return string
     */
    public function getRouteUrl()
    {
        return $this->routeUrl;
    }

    /**
     * @param string $routeUrl
     */
    public function setRouteUrl($routeUrl)
    {
        $this->routeUrl = $routeUrl;
    }
}
