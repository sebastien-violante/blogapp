<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    // The categoryList method allows to display the list of categories and to create a new one at the same time via a form
    #[Route('/category', name: 'app_category')]
    public function categoryList(
        EntityManagerInterface $entityManagerInterface,
        CategoryRepository $categoryRepository,
        Request $request,
    ): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category->setCreatedAt(new DateTimeImmutable());
            // transformation of the input given into a slug
            $category->setSlug(strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $form->getData()->getSlug()))));
            $entityManagerInterface->persist($category);
            $entityManagerInterface->flush();
            
            return $this->redirectToRoute('app_category');
        }
        
        return $this->renderForm('category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
            'categoryForm' => $form,
        ]);
    }

    // The categoryDelete method allows the deletion of a category name
    #[Route('/category/delete/{slug}', name: 'app_category_delete')]
    public function categoryDelete(
        CategoryRepository $categoryRepository,
        ArticleRepository $articleRepository,
        string $slug,
        ): Response
    {
            
        $category = $categoryRepository->findOneBySlug($slug);
        
        $articles = [];
        if ($category) {
            $articles = $category->getArticles()->getValues();
        }
        foreach ($articles as $article) {
            $category->removeArticle($article);
            dd($category->getId(), $article->getId());
        }
        return $this->redirectToRoute('app_home');
        
    }
}
