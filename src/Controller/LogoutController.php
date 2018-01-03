<?php
declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/logout", name="app_logout")
 */
class LogoutController
{
    public function __invoke() {}
}
