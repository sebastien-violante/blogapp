<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Service\ManageFile;
use Doctrine\Common\Annotations\Annotation\Enum;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/account')]
class ArticleController extends AbstractController
{
    private $File;

    public function __construct(ManageFile $manageFile) {
        $this->manageFile = $manageFile;
    }
        
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            # code...
        }
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findByAuthor($user),
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        ArticleRepository $articleRepository,
        EntityManagerInterface $entityManagerInterface,
        ): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setCreatedAt(new DateTimeImmutable());
            $file = $form['imageFile']->getData();
            $file_url = $this->manageFile->save_file($file);
            $article->setImageUrl($file_url);
            $article->setAuthor($this->getUser());
            $entityManagerInterface->persist($article);
            $entityManagerInterface->flush();
            
            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request, 
        Article $article, 
        ArticleRepository $articleRepository,
        EntityManagerInterface $entityManagerInterface,
        ): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUpdatedAt(new DateTimeImmutable());
            $file = $form['imageFile']->getData();
            if ($file) {
                $file_url = $this->manageFile->update_file($file, $article->getImageUrl());
                $article->setImageUrl($file_url);
            }
            $entityManagerInterface->persist($article);
            $entityManagerInterface->flush();
            
            return $this->redirectToRoute('app_single_article', [
                "slug" => $article->getSlug(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, ArticleRepository $articleRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            // $iamgeUrl is the url of the picture to delete with the article
            $imageUrl = $article->getImageUrl();
            $articleRepository->remove($article, true);
            $this->manageFile->remove_file($imageUrl);
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
