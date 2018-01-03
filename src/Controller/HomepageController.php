<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class HomepageController extends Controller
{
    /**
     * @Route(name="homepage")
     */
    public function indexAction()
    {
        return $this->render('Homepage/index.html.twig', []);
    }
}