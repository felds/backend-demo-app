<?php
declare(strict_types=1);

namespace App\Controller;

use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile")
 */
class ProfileController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $user = $this->getUser();

        return $this->render('Profile/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/edit")
     */
    public function editAction(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $form = $this->createForm(ProfileType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', "<b>Maneiro!</b> Seu perfil foi atualizado. :)");

            return $this->redirectToRoute('app_profile_index');
        }

        return $this->render('Profile/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
