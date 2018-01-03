<?php
declare(strict_types=1);

namespace App\Controller;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/register")
 */
class RegisterController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $form = $this->createForm(RegisterType::class);

        return $this->render('Register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}