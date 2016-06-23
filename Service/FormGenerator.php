<?php

namespace Buero\PactBundle\Service;

use Buero\PactBundle\Entity\EntityProperties;
use Buero\PactBundle\Entity\Task;
use Doctrine\Entity;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\FormFactory;


class FormGenerator
{
    private $formFactory;

    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function generateForm(Task $task, $options, $entity = null) {
        if ($entity) {
            $fb = $this->formFactory->createBuilder('Symfony\Component\Form\Extension\Core\Type\FormType', $entity, $options);
        } else {
            $class = $task->getEntityName();
            $fb = $this->formFactory->createBuilder('Symfony\Component\Form\Extension\Core\Type\FormType', new $class(), $options);
        }


        foreach ($task->getFields() as $field) {
            $fb->add($field);
        }
        return $fb->getForm();
    }
}
