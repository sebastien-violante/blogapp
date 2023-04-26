<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Service\CategoryService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    public function __construct(CategoryService $categoryService) {
        $categoryService->updateSession();
    }

    #[Route('/', name: 'app_home')]
    public function home(Request $request, ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
       
       
        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
           //'categories' => $categories,
            ]);
    }
    
    
    #[Route('/article/{slug}', name: 'app_single_article')]
    public function single(ArticleRepository $articleRepository, string $slug): Response
    {
        $article = $articleRepository->findOneBySlug($slug);
        
        return $this->render('blog/single.html.twig', [
            'article' => $article,
            
        ]);
    }

    #[Route('/category/{slug}', name: 'app_article_by_category')]
    public function article_by_category(ArticleRepository $articleRepository, string $slug, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->findOneBySlug($slug);
        $articles = [];
        if ($category) {
            $articles = $category->getArticles()->getValues();
        }
        
        return $this->render('blog/articles_by_category.html.twig', [
            'articles' => $articles,
            'category' => $category,
        ]);
    }

    /* #[Route('/article/{slug}', name: 'app_single_article', requirements:[
        'name' => "[a-z]{2,50}", // regex portant sur name : lettres entre a et z, entre 2 et 50 caractères
        'id' => "[0-9]{1,4}",
        ] )]
    public function index($id, $name): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'id' => $id,
            'name' => $name,
        ]);
    } */

}
