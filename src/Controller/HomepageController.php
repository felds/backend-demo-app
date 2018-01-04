<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class HomepageController extends Controller
{
    /**
     * @Route(name="homepage")
     */
    public function indexAction(AuthorizationCheckerInterface $authorizationChecker)
    {
        if ($authorizationChecker->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_profile_index', []);
        }

        return $this->render('Homepage/index.html.twig', []);
    }
}
