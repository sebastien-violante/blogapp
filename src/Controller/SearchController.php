<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    // The searchArticle method is used to find the articles which contain a world in their title or content
    #[Route('/search', name: 'app_search')]
    public function searchArticle(ArticleRepository $articleRepository): Response
    {
        $wordToSearch = $_POST['word-to-search'];
                
        return $this->render('search/index.html.twig', [
            'wordToSearch' => $wordToSearch,
            'articles' => $articleRepository->findByTitle($wordToSearch),
        ]);
    }
}
