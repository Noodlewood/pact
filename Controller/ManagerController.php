<?php

namespace Buero\PactBundle\Controller;

use Buero\PactBundle\Entity\EntityProperties;
use Buero\PactBundle\Entity\Task;
use Buero\PactBundle\Form\Type\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Serializer;

class ManagerController extends Controller
{
    /**
     * @Route("/manager/config", name="pact_manager_config")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function configAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task, [
            'action' => $this->generateUrl('pact_manager_config'),
            'entity_choices' => $this->getEntities(),
            'method' => 'POST',
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($task);
            $manager->flush();
        }
        
        $em = $this->getDoctrine()->getManager();
        $tasks = $em->getRepository(Task::class)->findAll();

        return $this->render('BueroPactBundle:Manage:config.html.twig', [
            'tasks' => $tasks,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/autoForm/{id}", name="pact_auto_form")
     * @param Request $request
     * @param Task $task
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function autoFormAction(Request $request, Task $task) {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository($task->getEntityName());
        $entity = $repo->find(rand(1, 10));


        $generator = $this->get('buero_pact.form_generator');
        $form = $generator->generateForm($task, [
            'action' => $this->generateUrl('pact_auto_form', ['id' => $task->getId()]),
            'method' => 'POST'
        ], $entity);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($entity);
            $manager->flush();
        }

        return $this->render('BueroPactBundle:Task:form.html.twig', [
            'task' => $task,
            'form' => $form->createView()
        ]);
    }
    
    private function getEntities() {
        $em = $this->getDoctrine()->getManager();
        $meta = $em->getMetadataFactory()->getAllMetadata();
        $entities = [];
        foreach ($meta as $m) {
            /* @var \Doctrine\ORM\Mapping\ClassMetadata $m */
            $path = $m->getName();
            $name = substr($path, strrpos($path, "\\") + 1);
            $entities[$name]['class'] = $path;
            $fields = [];
            foreach ($m->getFieldNames() as $fieldName) {
                $fields[] = $fieldName;
            }
            foreach ($m->getAssociationMappings() as $associationMapping) {
                $fields[] = $associationMapping["fieldName"];
            }
            $entities[$name]['fields'] = $fields;
        }

        return $entities;
    }
}
