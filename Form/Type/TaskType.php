<?php

namespace Buero\PactBundle\Form\Type;

use Buero\AccessBundle\Form\Type\OrderType;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formular zum Bearbeiten von Entities.
 */
class TaskType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entities = $options['entity_choices'];
        $choices = [];
        foreach ($entities as $name => $entity) {
            $choices[$name] = $entity["class"];
        }

        $builder->add('entityName', ChoiceType::class, [
            'label' => 'Name der Klasse',
            'choices' => $choices,
            'choices_as_values' => true,
            'placeholder' => '< Bitte Klasse auswählen >',
            'multiple' => false,
            'required' => true,
        ]);

        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) use ($entities) {
                $form = $event->getForm();
                $data = $event->getData();
                $fields = [];
                foreach ($entities as $name => $entity) {
                    if ($entity["class"] == $data["entityName"]) {
                        $fields = $entity["fields"];
                    }
                }
                $form->add('fields', ChoiceType::class, array(
                    'label' => 'Felder der Klasse',
                    'choices' => $fields,
                    'choices_as_values' => true,
                    'choice_label' => function($value, $key, $index) {
                        return $value;
                    },
                    'multiple' => true,
                    'required' => true,
                    'expanded' => true
                ));
            }
        );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Buero\PactBundle\Entity\Task',
            'entity_choices' => null,
        ));
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getBlockPrefix()
    {
        return 'task';
    }
}