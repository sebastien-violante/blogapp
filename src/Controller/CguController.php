<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CguController extends AbstractController
{
    // The generalConditions method allows to display general conditions of the site before registration
    #[Route('/cgu', name: 'app_cgu')]
    public function generalConditions(): Response
    {
        return $this->render('cgu/index.html.twig');
    }
}
