<?php
declare(strict_types=1);

namespace App\Controller;
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
        $form = $this->createNewForm();

        return $this->render('Register/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function createNewForm()
    {
        $builder = $this->createFormBuilder()
            ->add('email')
            ->add('password')
        ;

        return $builder->getForm();
    }
}