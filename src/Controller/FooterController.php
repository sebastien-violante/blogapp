<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    #[Route('/whoiam', name: 'app_whoiam')]
    public function whoiam(): Response
    {
        return $this->render('footer/whoiam.html.twig');
    }

    #[Route('/stack', name: 'app_stack')]
    public function stack(): Response
    {
        return $this->render('footer/stack.html.twig');
    }

    #[Route('/cgu', name: 'app_cgu')]
    public function cgu(): Response
    {
        return $this->render('footer/cgu.html.twig');
    }
}
