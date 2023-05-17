<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    // The about method is used to link the about page
    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('about/index.html.twig');
    }

    // The about method is used to link the page wich explains how to use the site
    #[Route('/explain', name: 'app_explain')]
    public function explanations(): Response
    {
        return $this->render('about/explain.html.twig');
    }
}
