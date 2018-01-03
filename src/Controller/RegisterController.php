<?php
declare(strict_types=1);

namespace App\Controller;
use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/register")
 */
class RegisterController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(RegisterType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $credentials = $form->getData();
            $user = User::fromCredentials($credentials);

            $em->persist($user);
            $em->flush();

            $this->addFlash("success", "<b>Maravilha!</b> Seu perfil foi criado com sucesso. Você já pode fazer login.");

            return $this->redirectToRoute('homepage');
        }

        return $this->render('Register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}