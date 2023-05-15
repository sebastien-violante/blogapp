<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FooterController extends AbstractController
{
    // The whoiam method allows to display informations about the creator of the site
    #[Route('/whoiam', name: 'app_whoiam')]
    public function whoiam(): Response
    {
        return $this->render('footer/whoiam.html.twig');
    }

    // The stack method allows to display informations about the stack ans references of the site
    #[Route('/stack', name: 'app_stack')]
    public function stack(): Response
    {
        return $this->render('footer/stack.html.twig');
    }

    // The cgu method allows to display the site's general conditions of use
    #[Route('/cgu', name: 'app_cgu')]
    public function cgu(): Response
    {
        return $this->render('footer/cgu.html.twig');
    }
}
