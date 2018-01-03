<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/login")
 */
class LoginController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(AuthenticationUtils $authUtils)
    {
        $lastUsername = $authUtils->getLastUsername();

        if ($error = $authUtils->getLastAuthenticationError()) {
            $this->addFlash('warning', $error->getMessage());
        }

        return $this->render('Login/index.html.twig', [
            'last_username' => $lastUsername,
        ]);
    }

    /**
     * @Route("/check")
     */
    public function checkAction() {}
}
