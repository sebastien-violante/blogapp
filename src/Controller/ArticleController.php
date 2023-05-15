<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Service\ManageFile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/account')]
class ArticleController extends AbstractController
{
    // The $File constant and the constructor are used to manage the downloading of images
    private $File;
    public function __construct(ManageFile $manageFile) {
        $this->manageFile = $manageFile;
    }
    
    // The articleList method displays all articles of the connected author
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function articleList(
        ArticleRepository $articleRepository,
        ): Response
    {
        $user = $this->getUser();
        
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findByAuthor($user),
        ]);
    }

    // The articleNew method allows to create a new article and to save it in the database
    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function articleNew(
        Request $request,
        EntityManagerInterface $entityManagerInterface,
        ): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Assignment of parameters missing from the form
            $article->setAuthor($this->getUser());
            $article->setCreatedAt(new DateTimeImmutable());
            // Retrieve the name of the file selected as an image
            $file = $form['imageFile']->getData();
            //Creation of a url to find the image file with the ManageFile service
            $file_url = $this->manageFile->save_file($file);
            $article->setImageUrl($file_url);
            $entityManagerInterface->persist($article);
            $entityManagerInterface->flush();
            
            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    // The articleEdit method allows you to modify an article
    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function articleEdit(
        Request $request, 
        Article $article, 
        EntityManagerInterface $entityManagerInterface,
        ): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUpdatedAt(new DateTimeImmutable());
            // Modification of the image path, if a new image is selected
            $file = $form['imageFile']->getData();
            if ($file) {
                $file_url = $this->manageFile->update_file($file, $article->getImageUrl());
                $article->setImageUrl($file_url);
            }
            $entityManagerInterface->persist($article);
            $entityManagerInterface->flush();
            
            // Back to the article's visualization
            return $this->redirectToRoute('app_single_article', [
                "slug" => $article->getSlug(),
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    // The articleDelete method is used to delete an article
    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function articleDelete(
        Request $request,
        Article $article,
        ArticleRepository $articleRepository
        ): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            // $imageUrl is the url of the picture to delete with the article to avoid keeping orphaned images
            $imageUrl = $article->getImageUrl();
            $articleRepository->remove($article, true);
            $this->manageFile->remove_file($imageUrl);
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }
}
