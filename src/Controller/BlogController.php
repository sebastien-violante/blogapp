<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\CommentRepository;
use App\Service\CategoryService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    // Categories are passed in session using the CategoryService to be available everywhere on the site
    public function __construct(CategoryService $categoryService) {
        $categoryService->updateSession();
    }

    //The home method displays the home page
    #[Route('/', name: 'app_home')]
    public function home(
        Request $request,
        ArticleRepository $articleRepository,
        ): Response
    {
        // The findBy with the first null array allows to retrieve all the items and to sort them according to the creation date
        $articles = $articleRepository->findBy([], ['createdAt' => 'DESC']);
        
        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
            ]);
    }
    
    // The articleSingle method alloes to display one single article, identified by its slug (important sor SEO)
    #[Route('/article/{slug}', name: 'app_single_article')]
    public function articleSingle(
        ArticleRepository $articleRepository,
        string $slug,
        CommentRepository $commentRepository,
        ): Response
    {
        $article = $articleRepository->findOneBySlug($slug);
        $comments = $commentRepository->findByArticle($article);
        // The constant likeNumber is created to display the number of likes given in comments. Isquote indicates that the article is liked
        $likeNumber = 0;
        foreach ($comments as $comment) {
            $likeNumber += $comment->isQuote();
        }

        return $this->render('blog/single.html.twig', [
            'article' => $article,
            'comments' => $commentRepository->findByArticle($article),
            'commentNumber' => count($commentRepository->findByArticle($article)),
            'likeNumber' => $likeNumber,
        ]);
    }

    // The article_by_category method retrieves and displays all the articles with the tag of the category
    #[Route('/category/{slug}', name: 'app_article_by_category')]
    public function article_by_category(
        string $slug,
        CategoryRepository $categoryRepository
        ): Response
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
}
