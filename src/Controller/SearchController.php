<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'app_search')]
    public function index(ArticleRepository $articleRepository): Response
    {
        //dd($_POST['word-to-search']);
        $wordToSearch = $_POST['word-to-search'];
                
        return $this->render('search/index.html.twig', [
            'wordToSearch' => $wordToSearch,
            'articles' => $articleRepository->findByTitle($wordToSearch),
        ]);
    }
}
