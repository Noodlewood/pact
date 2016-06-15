<?php

namespace Buero\PactBundle\Controller;

use Buero\AccessBundle\Service\CurrentUserService;
use Buero\PactBundle\Entity\Badge;
use Buero\PactBundle\Entity\Participant;
use Psiac\AccessBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\DiExtraBundle\Annotation as DI;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    /**
     * @var CurrentUserService
     * @DI\Inject("buero_access.current_user")
     */
    private $currentUserService;

    /**
     * @Route("/pact/dashboard", name="pact_dashboard")
     */
    public function dashboardAction()
    {
        /** @var User $currentUser */
        $currentUser = $this->currentUserService->getCurrentUser();
        
        if (!$currentUser->getSubject()) {
            $participant = new Participant();
            $participant->setExperience(1100);
            $badge = new Badge();
            $badge->setLevel(1);
            $participant->setUser($currentUser);
            $participant->addBadge($badge);
            $currentUser->setSubject($participant);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($currentUser);
            $manager->flush();
        }

        return $this->render('BueroPactBundle:Dashboard:show.html.twig', [
            'user' => $currentUser
        ]);
    }

    /**
     * @Route("/pact/expgained", name="pact_expgained")
     */
    public function expgainedAction(Request $request)
    {
        /** @var User $currentUser */
        $currentUser = $this->currentUserService->getCurrentUser();
        $exp = $request->get('exp');

        $currentUser->getSubject()->setExperience($currentUser->getSubject()->getExperience() + $exp);

        if ($currentUser->getSubject()->getExperience() > 2000) {
            $badge = new Badge();
            $badge->setLevel(2);
            $currentUser->getSubject()->addBadge($badge);
        }

        $manager = $this->getDoctrine()->getManager();
        $manager->persist($currentUser->getSubject());
        $manager->flush();
    }
}
